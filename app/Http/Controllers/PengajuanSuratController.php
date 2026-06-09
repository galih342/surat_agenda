<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class PengajuanSuratController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input Array (Perhatikan penambahan bintang * untuk validasi array)
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'perihal' => 'required|array',
            'perihal.*' => 'required|string|max:255',
            'tanggal_acara' => 'required|array',
            'tanggal_acara.*' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|array',
            'jam_mulai.*' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|array',
            'sampai_selesai_hidden' => 'nullable|array',
            'surat' => 'required|array',
            'surat.*' => 'required|mimes:pdf|max:2048',
        ]);

        $emailPengirim = session('google_email');
        $jumlahSurat = count($request->perihal);

        // 2. Looping dan Simpan Setiap Surat
        for ($i = 0; $i < $jumlahSurat; $i++) {
            // Cek apakah opsi "Sampai Selesai" dicentang pada kotak surat ini
            $isSampaiSelesai = isset($request->sampai_selesai_hidden[$i]) && $request->sampai_selesai_hidden[$i] == '1';

            // Upload file surat ke folder storage/app/public/dokumen_surat
            $file = $request->file('surat')[$i];
            // Tambahkan uniqid() biar kalau upload banyak file bersamaan, namanya nggak bentrok
            $namaFile = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen_surat', $namaFile, 'public');

            // Simpan data ke database
            PengajuanSurat::create([
                'nama_opd' => $request->nama_opd,
                'email_pengirim' => $emailPengirim,
                'perihal' => $request->perihal[$i],
                'tanggal_acara' => $request->tanggal_acara[$i],
                'jam_mulai' => $request->jam_mulai[$i],
                'jam_selesai' => $isSampaiSelesai ? null : ($request->jam_selesai[$i] ?? null),
                'file_surat' => $filePath,
                'status' => 'menunggu',
            ]);
        }

        // 3. Eksekusi Kematian Token QR
        $currentToken = session('current_qr_token');
        if ($currentToken) {
            \App\Models\QrToken::where('token', $currentToken)->update([
                'status' => 'USED',
                'used_by_email' => $emailPengirim
            ]);
            // Hapus session token agar bersih
            session()->forget('current_qr_token');
        }

        // 4. Redirect ke rute status dengan membawa parameter email
        return redirect()->route('surat.status', ['email' => $emailPengirim])
            ->with('success', 'Berhasil mengirim ' . $jumlahSurat . ' dokumen agenda!');
    }

    // Fungsi Status diubah menjadi berbasis Email
    public function status(Request $request)
    {
        // Ambil email dari URL
        $emailDiUrl = $request->query('email');
        // Ambil email asli dari Sesi Login Google
        $emailSesi = session('google_email');

        // PROTEKSI: Jika email di URL tidak sama dengan email yang sedang login, tendang!
        if (!$emailSesi || $emailDiUrl !== $emailSesi) {
            abort(403, 'Anda tidak diizinkan untuk melihat status surat milik akun lain.');
        }

        $surats = \App\Models\PengajuanSurat::where('email_pengirim', $emailSesi)->latest()->get();

        return view('status', compact('surats', 'emailSesi'));
    }

    // Fungsi Check Status (AJAX Realtime) juga diubah berbasis Email
    public function checkStatus(Request $request)
    {
        $email = $request->query('email') ?? session('google_email');

        // Ambil ID dan status terbaru dari semua surat milik email ini
        $surats = \App\Models\PengajuanSurat::where('email_pengirim', $email)->get(['id', 'status']);

        return response()->json(['surats' => $surats]);
    }

    public function form()
    {
        // Pagar Betis 1: Wajib memiliki Token QR di Session dan Wajib ada Email Google
        $token = session('current_qr_token');
        $email = session('google_email');

        if (!$token || !$email) {
            abort(403, 'AKSES DITOLAK: Anda wajib memindai QR Code resmi dan melakukan autentikasi Google untuk mengakses formulir ini.');
        }

        // Pagar Betis 2: Pastikan token tersebut statusnya memang masih ACTIVE di database
        $qr = \App\Models\QrToken::where('token', $token)->first();

        if (!$qr || $qr->status !== 'ACTIVE') {
            return redirect()->route('surat.status', ['email' => $email])
                ->with('error', 'QR Code sudah kedaluwarsa atau telah digunakan.');
        }

        // Jika lolos semua pengamanan, baru tampilkan form welcome
        return view('welcome');
    }

    // Fungsi Terima Massal
    public function bulkTerima(Request $request)
    {
        // Validasi array ID
        $request->validate(['ids' => 'required|array']);
        \App\Models\PengajuanSurat::whereIn('id', $request->ids)->update(['status' => 'diterima']);

        return response()->json(['success' => true, 'message' => 'Berhasil menerima surat massal']);
    }

    // Fungsi Tolak Massal
    public function bulkTolak(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        \App\Models\PengajuanSurat::whereIn('id', $request->ids)->update(['status' => 'ditolak']);

        return response()->json(['success' => true, 'message' => 'Berhasil menolak surat massal']);
    }

    // Fungsi Hapus (Soft Delete) Massal
    public function bulkDestroy(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        \App\Models\PengajuanSurat::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Berhasil memindahkan ke tong sampah']);
    }

    // Fungsi Selesai Massal
    public function bulkSelesai(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        \App\Models\PengajuanSurat::whereIn('id', $request->ids)->update(['status' => 'selesai']);

        return response()->json(['success' => true, 'message' => 'Berhasil menyelesaikan agenda massal']);
    }

    // Fungsi Batal Massal
    public function bulkBatal(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        \App\Models\PengajuanSurat::whereIn('id', $request->ids)->update(['status' => 'batal']);

        return response()->json(['success' => true, 'message' => 'Berhasil membatalkan agenda massal']);
    }

    // Fungsi Pulihkan (Restore) Massal
    public function bulkRestore(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        // Menggunakan withTrashed() untuk mencari data yang sudah masuk soft delete
        \App\Models\PengajuanSurat::withTrashed()->whereIn('id', $request->ids)->restore();

        return response()->json(['success' => true, 'message' => 'Berhasil memulihkan data massal']);
    }

    // Fungsi Hapus Permanen Massal & Hapus File Fisik
    public function bulkForceDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);

        // Cari data yang di tong sampah
        $surats = \App\Models\PengajuanSurat::withTrashed()->whereIn('id', $request->ids)->get();

        // Hapus file fisik PDF dari storage agar server tidak penuh
        foreach ($surats as $surat) {
            if ($surat->file_surat && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_surat)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($surat->file_surat);
            }
        }

        // Hapus datanya dari database secara permanen
        \App\Models\PengajuanSurat::withTrashed()->whereIn('id', $request->ids)->forceDelete();

        return response()->json(['success' => true, 'message' => 'Berhasil menghapus data permanen']);
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class PengajuanSuratController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
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
            $isSampaiSelesai = isset($request->sampai_selesai_hidden[$i]) && $request->sampai_selesai_hidden[$i] == '1';

            $file = $request->file('surat')[$i];
            $namaFile = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen_surat', $namaFile, 'public');

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

        // 4. Redirect kembali ke portal (welcome) dengan membawa pesan sukses
        return redirect()->route('surat.form')->with('success', 'Berhasil mengirim ' . $jumlahSurat . ' dokumen agenda!');
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
        $email = session('google_email');

        if (!$email) {
            abort(403, 'Sesi Anda tidak valid. Silakan scan QR Code kembali.');
        }

        // --- PROTEKSI LAPIS 1: CEK BLOKIR ---
        $diblokir = \App\Models\BlockedEmail::where('email', $email)->exists();
        if ($diblokir) {
            session()->forget(['google_email', 'current_qr_token']);
            abort(403, 'AKSES DITOLAK: Hak akses Anda telah dicabut/diblokir oleh Admin.');
        }

        // --- PROTEKSI LAPIS 2: CEK TOKEN DIHAPUS/EXPIRED ---
        $isReturningUser = \App\Models\QrToken::where('used_by_email', $email)->where('status', 'USED')->exists();
        $tokenDiSesi = session('current_qr_token');
        $isNewScan = \App\Models\QrToken::where('token', $tokenDiSesi)->where('status', 'ACTIVE')->exists();

        if (!$isReturningUser && !$isNewScan) {
            session()->forget(['google_email', 'current_qr_token']);
            abort(403, 'Sesi Anda telah berakhir atau dihapus. Silakan minta/scan QR Code baru untuk masuk kembali.');
        }

        // --- PROTEKSI LAPIS 3: ONE-TIME FILL (KTP INSTANSI) ---
        $profil = \App\Models\ProfilOpd::where('email', $email)->first();

        // Jika belum bikin profil (akun benar-benar baru / habis dihapus), paksa ke halaman setup
        if (!$profil) {
            return redirect()->route('surat.setup');
        }

        // Jika lolos semua, ambil riwayat surat miliknya
        $surats = \App\Models\PengajuanSurat::where('email_pengirim', $email)->latest()->get();

        // Lempar ke welcome.blade.php (Nama OPD otomatis readonly dari database)
        return view('welcome', [
            'surats' => $surats,
            'email' => $email,
            'opdTerakhir' => $profil->nama_opd
        ]);
    }

    // Fungsi Menampilkan Halaman One-Time Fill
    public function setupOpd()
    {
        $email = session('google_email');
        if (!$email)
            abort(403, 'AKSES DITOLAK');

        // PROTEKSI TOMBOL BACK: Jika sudah punya data tapi nekat balik ke halaman ini, tendang ke Portal
        if (\App\Models\ProfilOpd::where('email', $email)->exists()) {
            return redirect()->route('surat.form')->withErrors(['Peringatan' => 'Anda sudah menetapkan nama instansi.']);
        }

        return view('setup-opd', compact('email'));
    }

    // Fungsi Menyimpan Data OPD Permanen
    // Fungsi Menyimpan Data OPD Permanen + Kunci Token QR langsung di sini
    public function storeSetupOpd(Request $request)
    {
        $request->validate(['nama_opd' => 'required|string|max:255']);
        $email = session('google_email');

        // Proteksi Ganda (Double Submit Prevention)
        if (\App\Models\ProfilOpd::where('email', $email)->exists()) {
            return redirect()->route('surat.form');
        }

        // 1. Simpan KTP Instansi secara permanen
        \App\Models\ProfilOpd::create([
            'email' => $email,
            'nama_opd' => $request->nama_opd
        ]);

        // 2. PINDAH KE SINI: Langsung kunci Token QR begitu selesai isi nama OPD
        $currentToken = session('current_qr_token');
        if ($currentToken) {
            \App\Models\QrToken::where('token', $currentToken)->update([
                'status' => 'USED',
                'used_by_email' => $email
            ]);
        }

        return redirect()->route('surat.form');
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

    // Fungsi untuk membatalkan pengajuan dari sisi Tamu/Instansi
    public function batalkanOlehUser($id)
    {
        $email = session('google_email');

        // Cari surat berdasarkan ID dan pastikan pemiliknya adalah email yang sedang login
        $surat = \App\Models\PengajuanSurat::where('id', $id)
            ->where('email_pengirim', $email)
            ->firstOrFail();

        // Hanya izinkan pembatalan jika statusnya masih 'menunggu'
        if ($surat->status === 'menunggu') {
            $surat->update(['status' => 'batal']);
            return redirect()->route('surat.form')->with('success', 'Dokumen pengajuan berhasil dibatalkan.');
        }

        return redirect()->route('surat.form')->withErrors(['Peringatan' => 'Gagal membatalkan. Status surat mungkin sudah diproses oleh Admin.']);
    }


}

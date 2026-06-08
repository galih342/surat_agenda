<?php

namespace App\Http\Controllers;

use App\Models\PengajuanSurat;
use Illuminate\Http\Request;

class PengajuanSuratController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'perihal' => 'required|string|max:255',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|required_without:sampai_selesai|date_format:H:i',
            'surat' => 'required|mimes:pdf|max:2048',
        ]);

        // Upload file surat ke folder storage/app/public/dokumen_surat
        // Ambil file aslinya
        $file = $request->file('surat');
        // Buat nama baru: format timestamp_nama-asli-file.pdf
        $namaFile = time() . '_' . $file->getClientOriginalName();
        // Simpan menggunakan storeAs() agar namanya tidak di-hash acak
        $filePath = $file->storeAs('dokumen_surat', $namaFile, 'public');

        // Simpan data ke database
        // Simpan data ke database dan tampung ke variabel $pengajuan
        $pengajuan = PengajuanSurat::create([
            'nama_opd' => $request->nama_opd,
            'perihal' => $request->perihal,
            'tanggal_acara' => $request->tanggal_acara,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->has('sampai_selesai') ? null : $request->jam_selesai,
            'file_surat' => $filePath,
        ]);

        // Redirect ke route status real-time dengan membawa ID surat yang baru dibuat
        return redirect()->route('pengajuan.status', $pengajuan->id);
    }

    public function status($id)
    {
        $surat = \App\Models\PengajuanSurat::findOrFail($id);
        return view('status', compact('surat'));
    }

    public function checkStatus($id)
    {
        $surat = \App\Models\PengajuanSurat::findOrFail($id);
        // Hanya kembalikan data status dalam bentuk JSON
        return response()->json(['status' => $surat->status]);
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

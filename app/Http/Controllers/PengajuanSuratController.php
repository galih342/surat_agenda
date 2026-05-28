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
        $filePath = $request->file('surat')->store('dokumen_surat', 'public');

        // Simpan data ke database
        PengajuanSurat::create([
            'nama_opd' => $request->nama_opd,
            'perihal' => $request->perihal,
            'tanggal_acara' => $request->tanggal_acara,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->has('sampai_selesai') ? null : $request->jam_selesai,
            'file_surat' => $filePath,
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Pengajuan surat berhasil dikirim!');
    }
}

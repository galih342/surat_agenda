<?php

namespace Database\Seeders;

use App\Models\PengajuanSurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PengajuanSuratSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan folder siap
        if (!Storage::disk('public')->exists('surat')) {
            Storage::disk('public')->makeDirectory('surat');
        }

        // 2. Bikin 1 file PDF dummy fisik untuk dipakai beramai-ramai (biar hemat storage)
        $fileName = 'dummy_surat_massal.pdf';
        Storage::disk('public')->put('surat/' . $fileName, 'Ini dokumen dummy massal untuk testing paginasi.');
        $filePath = 'surat/' . $fileName;

        // Daftar nama OPD acak biar datanya bervariasi
        $opdList = [
            'Dinas Komunikasi dan Informatika',
            'Badan Kepegawaian Daerah',
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Sosial',
            'Dinas Lingkungan Hidup',
            'Dinas Pekerjaan Umum',
            'Dinas Perhubungan'
        ];

        // 3. Generate 20 Data untuk Masing-masing Tabel Utama
        $statusUtama = ['pending', 'diterima', 'ditolak', 'selesai', 'batal'];

        foreach ($statusUtama as $status) {
            for ($i = 1; $i <= 20; $i++) {
                PengajuanSurat::create([
                    'nama_opd' => $opdList[array_rand($opdList)],
                    'perihal' => 'Pengajuan Agenda ' . ucfirst($status) . ' Nomor ' . $i,
                    'tanggal_acara' => now()->addDays(rand(-10, 30))->format('Y-m-d'),
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '12:00:00',
                    'file_surat' => $filePath,
                    'status' => $status,
                ]);
            }
        }

        // 4. Generate 20 Data HAPUS untuk Masing-masing Sub-Tab di Tong Sampah
        $statusSampah = ['ditolak', 'selesai', 'batal'];

        foreach ($statusSampah as $status) {
            for ($i = 1; $i <= 20; $i++) {
                $suratSampah = PengajuanSurat::create([
                    'nama_opd' => $opdList[array_rand($opdList)],
                    'perihal' => 'Arsip Terhapus (' . ucfirst($status) . ') Nomor ' . $i,
                    'tanggal_acara' => now()->subDays(rand(1, 60))->format('Y-m-d'),
                    'jam_mulai' => '09:00:00',
                    'jam_selesai' => '14:00:00',
                    'file_surat' => $filePath,
                    'status' => $status,
                ]);

                // Langsung masukkan ke tong sampah (Soft Delete)
                $suratSampah->delete();
            }
        }
    }
}
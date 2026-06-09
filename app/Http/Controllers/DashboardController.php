<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap parameter dari URL (Form Pencarian)
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');

        // 2. Buat Base Query yang sudah difilter
        $baseQuery = PengajuanSurat::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_opd', 'like', "%{$search}%")
                        ->orWhere('perihal', 'like', "%{$search}%");
                });
            })
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal_acara', $tanggal);
            });

        // 3. Pecah data berdasarkan status dari baseQuery yang sudah terfilter
        $suratUtama = (clone $baseQuery)->where('status', 'pending')->latest()->paginate(10, ['*'], 'p_utama')->withQueryString();
        $suratDiterima = (clone $baseQuery)->where('status', 'diterima')->latest()->paginate(10, ['*'], 'p_diterima')->withQueryString();
        $suratDitolak = (clone $baseQuery)->where('status', 'ditolak')->latest()->paginate(10, ['*'], 'p_ditolak')->withQueryString();
        $suratSelesai = (clone $baseQuery)->where('status', 'selesai')->latest()->paginate(10, ['*'], 'p_selesai')->withQueryString();
        $suratBatal = (clone $baseQuery)->where('status', 'batal')->latest()->paginate(10, ['*'], 'p_batal')->withQueryString();

        // 4. Data Tong Sampah (Juga difilter jika dicari)
        $sampahBaseQuery = PengajuanSurat::onlyTrashed()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_opd', 'like', "%{$search}%")
                        ->orWhere('perihal', 'like', "%{$search}%");
                });
            })
            ->when($tanggal, function ($query, $tanggal) {
                return $query->whereDate('tanggal_acara', $tanggal);
            });

        $sampahDitolak = (clone $sampahBaseQuery)->where('status', 'ditolak')->latest()->paginate(10, ['*'], 's_ditolak')->withQueryString();
        $sampahSelesai = (clone $sampahBaseQuery)->where('status', 'selesai')->latest()->paginate(10, ['*'], 's_selesai')->withQueryString();
        $sampahBatal = (clone $sampahBaseQuery)->where('status', 'batal')->latest()->paginate(10, ['*'], 's_batal')->withQueryString();

        // Update count menggunakan ->total() dari paginator
        $countPending = $suratUtama->total();
        $countDiterima = $suratDiterima->total();
        $countDitolak = $suratDitolak->total();

        // BLOK AJAX (Tetap sama seperti aslinya)
        if ($request->ajax()) {
            if ($request->has('p_utama')) {
                return view('table.tabelSurat', ['surat' => $suratUtama])->render();
            }
            if ($request->has('p_diterima')) {
                return view('table.tabelDiterima', ['surat' => $suratDiterima])->render();
            }
            if ($request->has('p_ditolak')) {
                return view('table.tabelDitolak', ['surat' => $suratDitolak])->render();
            }
            if ($request->has('p_selesai')) {
                return view('table.tabelSelesai', ['surat' => $suratSelesai])->render();
            }
            if ($request->has('p_batal')) {
                return view('table.tabelBatal', ['surat' => $suratBatal])->render();
            }
            if ($request->has('s_ditolak')) {
                return view('table.tabelsampah', [
                    'surat' => $sampahDitolak,
                    'tipe' => 'sampahDitolak'
                ])->render();
            }
            if ($request->has('s_selesai')) {
                return view('table.tabelsampah', [
                    'surat' => $sampahSelesai,
                    'tipe' => 'sampahSelesai'
                ])->render();
            }
            if ($request->has('s_batal')) {
                return view('table.tabelsampah', [
                    'surat' => $sampahBatal,
                    'tipe' => 'sampahBatal'
                ])->render();
            }

            return view('table.tabelSurat', ['surat' => $suratUtama])->render();
        }

        // Ambil data semua admin untuk tab Manajemen Akun
        $admins = User::latest()->get();

        // Ambil semua data QR Token
        $qrTokens = \App\Models\QrToken::latest()->get();

        // Return View
        return view('dashboard', compact(
            'suratUtama',
            'suratDiterima',
            'suratDitolak',
            'suratSelesai',
            'suratBatal',
            'sampahDitolak',
            'sampahSelesai',
            'sampahBatal',
            'countPending',
            'countDiterima',
            'countDitolak',
            'admins',
            'qrTokens'
        ));
    }

    public function terima($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->update(['status' => 'diterima']);

        return redirect()->back()->with('success', 'Surat berhasil diterima dan dijadwalkan.');
    }

    public function tolak($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Surat telah ditolak.');
    }

    public function selesai($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->update(['status' => 'selesai']);
        return redirect()->back()->with('success', 'Agenda telah diselesaikan.');
    }

    public function batal($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->update(['status' => 'batal']);
        return redirect()->back()->with('success', 'Agenda dibatalkan.');
    }

    public function destroy($id)
    {
        $surat = PengajuanSurat::findOrFail($id);
        $surat->delete(); // Ini otomatis jadi Soft Delete karena model sudah disetting

        return redirect()->back()->with('success', 'Data berhasil dipindah ke tong sampah.');
    }

    public function sampah()
    {
        // Ambil HANYA data yang dihapus (onlyTrashed), lalu pisahkan berdasarkan status
        $sampahDitolak = PengajuanSurat::onlyTrashed()->where('status', 'ditolak')->latest()->get();
        $sampahSelesai = PengajuanSurat::onlyTrashed()->where('status', 'selesai')->latest()->get();
        $sampahBatal = PengajuanSurat::onlyTrashed()->where('status', 'batal')->latest()->get();

        // Mengirim ke view sampah (nanti kita buat)
        return view('sampah', compact('sampahDitolak', 'sampahSelesai', 'sampahBatal'));
    }

    public function restore($id)
    {
        // Mencari data yang berada di tong sampah (onlyTrashed)
        $surat = PengajuanSurat::onlyTrashed()->findOrFail($id);
        $surat->restore(); // Mengembalikan data ke status aktif semula

        return redirect()->back()->with('success', 'Data berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $surat = PengajuanSurat::onlyTrashed()->findOrFail($id);

        // Hapus file fisik dari storage jika diperlukan sebelum data di-hard delete
        if (\Storage::disk('public')->exists($surat->file_surat)) {
            \Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->forceDelete(); // Hapus permanen dari database

        return redirect()->back()->with('success', 'Data telah dihapus secara permanen.');
    }

    public function generateQr()
    {
        // Membuat string token unik acak berstempel waktu
        $tokenStr = 'OPD-' . strtoupper(bin2hex(random_bytes(4))) . '-' . time();

        // Simpan token baru ke database dengan status ACTIVE
        \App\Models\QrToken::create([
            'token' => $tokenStr,
            'status' => 'ACTIVE'
        ]);

        // Kirim url mentah hasil generate kembali ke halaman admin
        $linkHasilScan = route('qr.scan', ['token' => $tokenStr]);

        return back()->with('success_qr', $linkHasilScan);
    }

    // Memblokir Akses QR
    // Memblokir Akses Berdasarkan Email
    public function blokirQr($id)
    {
        $qr = \App\Models\QrToken::findOrFail($id);

        // Jika QR sudah ada emailnya, masukkan email tersebut ke daftar blokir permanen
        if ($qr->used_by_email) {
            \App\Models\BlockedEmail::firstOrCreate([
                'email' => $qr->used_by_email
            ]);
        }

        return redirect()->back()->with('success', 'Akses email instansi berhasil diblokir secara permanen!');
    }

    // Membuka Blokir Akses Email
    public function unblockQr($id)
    {
        $qr = \App\Models\QrToken::findOrFail($id);

        if ($qr->used_by_email) {
            \App\Models\BlockedEmail::where('email', $qr->used_by_email)->delete();
        }

        return redirect()->back()->with('success', 'Blokir email berhasil dibuka.');
    }

    // Menghapus Akses QR
    public function hapusQr($id)
    {
        $qr = \App\Models\QrToken::findOrFail($id);
        $qr->delete();
        return redirect()->back()->with('success', 'QR Code berhasil dihapus permanen.');
    }

    // Menghapus Banyak QR Sekaligus (Bulk Action)
    public function bulkHapusQr(Request $request)
    {
        $ids = $request->input('ids');

        if ($ids && is_array($ids)) {
            \App\Models\QrToken::whereIn('id', $ids)->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih'], 400);
    }
}

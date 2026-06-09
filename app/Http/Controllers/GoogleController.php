<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Mengarahkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani kembalian data dari Google setelah login sukses
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $emailSekarang = $googleUser->getEmail();

            // --- JANTUNG KEAMANAN: CEK DAFTAR BLOKIR ---
            $isBlocked = \App\Models\BlockedEmail::where('email', $emailSekarang)->exists();
            if ($isBlocked) {
                // Langsung tendang ke halaman error jika email ada di database blokir
                return view('errors.akses_ditolak');
            }

            session(['google_email' => $emailSekarang]);

            $token = session('current_qr_token');
            $qr = \App\Models\QrToken::where('token', $token)->first();

            if (!$qr) {
                abort(403, 'Token akses tidak valid atau sesi telah berakhir.');
            }

            // --- JANTUNG KEAMANAN: LOCKING EMAIL ---
            if ($qr->status === 'USED') {
                // Jika sudah dipakai, cek apakah email yang login sekarang SAMA dengan email pemakai awal
                // Jika sudah dipakai, cek apakah email yang login sekarang SAMA dengan email pemakai awal
                if ($qr->used_by_email !== $emailSekarang) {
                    // Tampilkan halaman blade khusus penolakan akses
                    return view('errors.akses_ditolak');
                }

                // Jika email cocok, bolehkan melihat status suratnya
                return redirect()->route('surat.status', ['email' => $qr->used_by_email]);
            }

            // Jika status masih ACTIVE, silakan masuk ke form
            return redirect()->route('surat.form');

        } catch (\Exception $e) {
            return view('errors.akses_ditolak');
        }
    }
}
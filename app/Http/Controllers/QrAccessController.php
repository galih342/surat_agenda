<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrToken;

class QrAccessController extends Controller
{
    public function scan(Request $request)
    {
        $token = $request->query('token');

        // 1. Validasi keberadaan token
        $qr = \App\Models\QrToken::where('token', $token)->firstOrFail();

        // 2. Cek apakah token fisik ini sudah diblokir
        if ($qr->status === 'BLOCKED') {
            return view('errors.akses_ditolak');
        }

        // 3. Simpan token ke session agar terbawa setelah login Google
        session(['current_qr_token' => $token]);

        // 4. PAKSA LOGIN GOOGLE DULU
        return redirect()->route('google.login');
    }
}
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
        $qr = QrToken::where('token', $token)->firstOrFail();

        // 2. Simpan token ke session agar terbawa setelah login Google
        session(['current_qr_token' => $token]);

        // 3. PAKSA LOGIN GOOGLE DULU (Apapun status tokennya)
        // Kita perlu tahu "Siapa Anda" sebelum memberi akses
        return redirect()->route('google.login');
    }
}
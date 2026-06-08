<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // 1. Menampilkan halaman form tambah admin
    public function create()
    {
        return view('admin.create');
    }

    // 2. Menyimpan data admin baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super-admin'
        ]);

        // 1. Buat user tanpa memasukkan 'role' ke tabel users
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        // 2. Berikan role pakai Spatie
        $user->assignRole($request->role);

        return redirect()->route('dashboard')->with('success', 'Admin berhasil ditambahkan!');
    }
    // 3. Menampilkan halaman form edit admin
    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    // 4. Memperbarui data admin di database
// 4. Memperbarui data admin di database
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // TYPO FIX: Hapus rule 'username' di tengah-tengah karena Laravel tidak punya validasi bernama 'username'
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['admin', 'super-admin'])],
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;

        // HAPUS: $admin->role = $request->role;
        // GANTI JADI SPATIE:
        $admin->syncRoles($request->role);

        // Jika kolom input password diisi, baru lakukan update enkripsi
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('dashboard')->with('success', 'Data akun admin berhasil diperbarui!');
    }

    // 5. Menghapus akun admin
    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // PROTEKSI: Mencegah akun yang sedang login menghapus dirinya sendiri
        if (auth()->id() == $admin->id) {
            return redirect()->back()->with('error', 'Anda tidak diperbolehkan menghapus akun Anda sendiri!');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Akun admin berhasil dihapus.');
    }

    // Fungsi untuk memproses penghapusan banyak akun sekaligus (via AJAX)
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        // Proteksi: Hapus ID yang sedang login dari daftar yang akan didelete 
        // supaya tidak bisa hapus diri sendiri meskipun diretas lewat Inspect Element
        $ids = array_diff($ids, [auth()->id()]);

        User::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}
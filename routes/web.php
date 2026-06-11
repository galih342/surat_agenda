<?php

use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\QrAccessController;

/*
|--------------------------------------------------------------------------
| AREA PUBLIK (Bisa diakses siapa saja tanpa login)
|--------------------------------------------------------------------------
*/
// Root langsung mental ke halaman login pengelola
Route::redirect('/', '/login');

// Form Pengajuan (Hanya bisa diakses jika lolos validasi QR & Google)
Route::get('/form-pengajuan', [PengajuanSuratController::class, 'form'])->name('surat.form');
Route::post('/simpan-surat', [PengajuanSuratController::class, 'store']);

// Cek Status (Berdasarkan Email Google)
// Route::get('/pengajuan/status', [PengajuanSuratController::class, 'status'])->name('surat.status');
Route::get('/pengajuan/status/check', [PengajuanSuratController::class, 'checkStatus']);

// Setup OPD (Satu kali isi)
Route::get('/setup-opd', [PengajuanSuratController::class, 'setupOpd'])->name('surat.setup');
Route::post('/simpan-setup-opd', [PengajuanSuratController::class, 'storeSetupOpd'])->name('surat.store-setup');

// Rute untuk pengguna membatalkan suratnya sendiri
Route::patch('/pengajuan/{id}/batalkan', [PengajuanSuratController::class, 'batalkanOlehUser'])->name('surat.batal-user');


/*
|--------------------------------------------------------------------------
| AREA PRIVAT (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Profil Default Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Halaman Utama Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | AKSES ADMIN & SUPER-ADMIN (Manajemen Surat)
    |--------------------------------------------------------------------------
    | Nanti kalau mau diperketat, bisa tambah ->middleware('role:admin|super-admin')
    */
    Route::prefix('dashboard/surat')->name('surat.')->group(function () {

        // 1. Aksi Massal (Bulk) HARUS DI ATAS agar url 'bulk' tidak ditelan oleh {id}
        Route::patch('/bulk/terima', [PengajuanSuratController::class, 'bulkTerima'])->name('bulk-terima');
        Route::patch('/bulk/tolak', [PengajuanSuratController::class, 'bulkTolak'])->name('bulk-tolak');
        Route::patch('/bulk/selesai', [PengajuanSuratController::class, 'bulkSelesai'])->name('bulk-selesai');
        Route::patch('/bulk/batal', [PengajuanSuratController::class, 'bulkBatal'])->name('bulk-batal');

        // 2. Aksi Tunggal HARUS DI BAWAH
        Route::patch('/{id}/terima', [DashboardController::class, 'terima'])->name('terima');
        Route::patch('/{id}/tolak', [DashboardController::class, 'tolak'])->name('tolak');
        Route::patch('/{id}/selesai', [DashboardController::class, 'selesai'])->name('selesai');
        Route::patch('/{id}/batal', [DashboardController::class, 'batal'])->name('batal');
    });

    /*
    |--------------------------------------------------------------------------
    | AKSES KHUSUS SUPER-ADMIN (Manajemen Akun)
    |--------------------------------------------------------------------------
    | Nanti saat Spatie aktif, tinggal uncomment middleware di bawah ini
    */
    Route::middleware(['role:super-admin'])->group(function () {

        // Manajemen Tong Sampah (Tunggal & Bulk)
        Route::prefix('dashboard/surat')->name('surat.')->group(function () {

            // Aksi Massal (BulksuperAdmin) - URL dirapikan agar selaras dengan prefix
            Route::delete('/bulk/force', [PengajuanSuratController::class, 'bulkForceDelete'])->name('bulk-force');
            Route::delete('/bulk/destroy', [PengajuanSuratController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::patch('/bulk/restore', [PengajuanSuratController::class, 'bulkRestore'])->name('bulk-restore');


            // Manajemen Tong Sampah (Tunggal)
            Route::delete('/{id}', [DashboardController::class, 'destroy'])->name('destroy');
            Route::get('/sampah/view', [DashboardController::class, 'sampah'])->name('sampah');
            Route::post('/{id}/restore', [DashboardController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [DashboardController::class, 'forceDelete'])->name('forceDelete');
        });

        // Manajemen Akun Admin
        Route::resource('admin', AdminController::class)->except(['show', 'index']);
        Route::delete('/admin/bulk/delete', [AdminController::class, 'bulkDelete'])->name('admin.bulk-delete');

    });

    // Tambahkan ini di dalam kelompok rute super-admin web.php
    Route::post('/dashboard/qr/generate', [DashboardController::class, 'generateQr'])->name('surat.qr-generate');

    // Aksi Massal (Bulk) untuk QR
    Route::delete('/dashboard/qr/bulk/hapus', [DashboardController::class, 'bulkHapusQr'])->name('qr.bulk-hapus');
    Route::patch('/dashboard/qr/{id}/blokir', [DashboardController::class, 'blokirQr'])->name('qr.blokir');
    Route::patch('/dashboard/qr/{id}/unblock', [DashboardController::class, 'unblockQr'])->name('qr.unblock');
    Route::delete('/dashboard/qr/{id}/hapus', [DashboardController::class, 'hapusQr'])->name('qr.hapus');

});

/*
|--------------------------------------------------------------------------
| AREA Google Auth/redir/qr akses
|--------------------------------------------------------------------------
*/
//qr akses
Route::get('/akses-surat', [QrAccessController::class, 'scan'])->name('qr.scan');
//Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
//redir
Route::redirect('/register', '/login');
require __DIR__ . '/auth.php';
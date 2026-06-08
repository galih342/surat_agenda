<?php

use App\Http\Controllers\PengajuanSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AREA PUBLIK (Bisa diakses siapa saja tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

// Form Pengajuan & Cek Status (Untuk Masyarakat)
Route::post('/simpan-surat', [PengajuanSuratController::class, 'store']);
Route::get('/pengajuan/status/{id}', [PengajuanSuratController::class, 'status'])->name('pengajuan.status');
Route::get('/pengajuan/status/{id}/check', [PengajuanSuratController::class, 'checkStatus']);


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

        // Aksi Tunggal
        Route::patch('/{id}/terima', [DashboardController::class, 'terima'])->name('terima');
        Route::patch('/{id}/tolak', [DashboardController::class, 'tolak'])->name('tolak');
        Route::patch('/{id}/selesai', [DashboardController::class, 'selesai'])->name('selesai');
        Route::patch('/{id}/batal', [DashboardController::class, 'batal'])->name('batal');

        // Aksi Massal (Bulk) - URL dirapikan agar selaras dengan prefix
        Route::patch('/bulk/terima', [PengajuanSuratController::class, 'bulkTerima'])->name('bulk-terima');
        Route::patch('/bulk/tolak', [PengajuanSuratController::class, 'bulkTolak'])->name('bulk-tolak');
        Route::patch('/bulk/selesai', [PengajuanSuratController::class, 'bulkSelesai'])->name('bulk-selesai');
        Route::patch('/bulk/batal', [PengajuanSuratController::class, 'bulkBatal'])->name('bulk-batal');
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
            // Manajemen Tong Sampah (Tunggal)
            Route::delete('/{id}', [DashboardController::class, 'destroy'])->name('destroy');
            Route::get('/sampah/view', [DashboardController::class, 'sampah'])->name('sampah');
            Route::post('/{id}/restore', [DashboardController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force', [DashboardController::class, 'forceDelete'])->name('forceDelete');

            // Aksi Massal (BulksuperAdmin) - URL dirapikan agar selaras dengan prefix
            Route::delete('/bulk/destroy', [PengajuanSuratController::class, 'bulkDestroy'])->name('bulk-destroy');
            Route::patch('/bulk/restore', [PengajuanSuratController::class, 'bulkRestore'])->name('bulk-restore');
            Route::delete('/bulk/force', [PengajuanSuratController::class, 'bulkForceDelete'])->name('bulk-force');
        });

        // Manajemen Akun Admin
        Route::resource('admin', AdminController::class)->except(['show', 'index']);
        Route::delete('/admin/bulk/delete', [AdminController::class, 'bulkDelete'])->name('admin.bulk-delete');

    });

});

require __DIR__ . '/auth.php';
<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masyarakat\ComplaintController as UserComplaintController;
use App\Http\Controllers\Masyarakat\DashboardController as UserDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/panduan', [HomeController::class, 'guide'])->name('guide');
Route::get('/lacak', [HomeController::class, 'track'])->name('track');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Masyarakat & Admin pengaduan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('pengaduan')->name('complaints.')->group(function () {
        Route::get('/', [UserComplaintController::class, 'index'])->name('index');
        Route::get('/buat', [UserComplaintController::class, 'create'])->name('create');
        Route::post('/', [UserComplaintController::class, 'store'])->name('store');
        Route::get('/{id}', [UserComplaintController::class, 'show'])->name('show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengaduan
    Route::prefix('pengaduan')->name('complaints.')->group(function () {
        Route::get('/', [AdminComplaintController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminComplaintController::class, 'show'])->name('show');
        Route::post('/{id}/verifikasi', [AdminComplaintController::class, 'verify'])->name('verify');
        Route::post('/{id}/tolak', [AdminComplaintController::class, 'reject'])->name('reject');
        Route::post('/{id}/status', [AdminComplaintController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/tanggapan', [AdminComplaintController::class, 'addResponse'])->name('add-response');
    });

    // Manajemen Kategori
    Route::resource('kategori', AdminCategoryController::class)->names('categories');

    // Manajemen Laporan & Rekapitulasi
    Route::prefix('laporan')->name('reports.')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('index');
        Route::get('/cetak', [AdminReportController::class, 'print'])->name('print');
        Route::get('/excel', [AdminReportController::class, 'exportExcel'])->name('excel');
    });
});

require __DIR__.'/auth.php';

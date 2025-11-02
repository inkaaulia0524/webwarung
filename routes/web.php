<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman welcome
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

// Semua pengguna yang login
Route::middleware('auth')->group(function () {

    // === KASIR ===
    Route::middleware('kasir')->group(function () {
        Route::get('/dashboard', function () {
            return view('kasir.dashboard');
        })->name('kasir.dashboard');

        // Profil Kasir
        Route::get('/kasir/profile', [ProfileController::class, 'edit'])->name('kasir.profile.edit');
        Route::patch('/kasir/profile', [ProfileController::class, 'update'])->name('kasir.profile.update');
    });

    // === ADMIN ===
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Profil Admin
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    });

});

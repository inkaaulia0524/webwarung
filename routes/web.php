<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman welcome
Route::get('/login', function () {
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
        // stok barang
        Route::resource('/kasir/stok', App\Http\Controllers\Kasir\StokBarangController::class)->only(['index']);

    });

    // === ADMIN ===
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Profil Admin
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Manajemen Barang
        Route::resource('/admin/barang', App\Http\Controllers\Admin\BarangController::class);
        Route::resource('/admin/supplier', App\Http\Controllers\Admin\SupplierController::class);
    });

});

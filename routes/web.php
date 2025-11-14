<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\Admin\PengeluaranController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\PenjualansController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GrafikController;
use App\Http\Controllers\Admin\LaporanController;
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
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/grafik', [GrafikController::class, 'index'])->name('grafik.index');
        // Profil Admin
        Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Manajemen Barang
        Route::resource('/admin/barang', App\Http\Controllers\Admin\BarangController::class);
        Route::resource('/admin/supplier', App\Http\Controllers\Admin\SupplierController::class);
        Route::resource('/admin/pembelian', App\Http\Controllers\Admin\PembelianController::class);
        Route::resource('/admin/pengeluaran', App\Http\Controllers\Admin\PengeluaranController::class);
    
        // Laporan
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/admin/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
        Route::get('/admin/laporan/stok/export', [LaporanController::class, 'stokExport'])->name('laporan.stok.export');
        Route::get('/admin/laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.labaRugi');
});

    Route::resource('penjualan', PenjualansController::class);

});

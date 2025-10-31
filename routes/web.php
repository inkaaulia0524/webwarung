<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Route untuk dashboard umum
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== ADMIN ==================
Route::middleware(['auth', 'RoleCheck:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('barang', BarangController::class);
    Route::resource('supplier', SupplierController::class);
});

// ================== KASIR ==================
Route::middleware(['auth', 'RoleCheck:kasir'])->group(function () {
    Route::get('/kasir', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
});

// ================== SUPPLIER ==================
Route::middleware(['auth', 'RoleCheck:supplier'])->group(function () {
    Route::get('/supplier', function () {
        return view('supplier.dashboard');
    })->name('supplier.dashboard');
});

require __DIR__.'/auth.php';

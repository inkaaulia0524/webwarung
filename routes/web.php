<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

// semua yang login
Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // dashboard kasir
    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->middleware('kasir')->name('kasir.dashboard');

    // dashboard admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->middleware('admin')->name('admin.dashboard');
});

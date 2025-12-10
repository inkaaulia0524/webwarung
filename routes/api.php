<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\SupplierApiController;
use App\Http\Controllers\Api\PengeluaranApiController;
use App\Http\Controllers\Api\HutangPiutangApiController;
use App\Http\Controllers\Api\PembelianApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\LaporanApiController; 
use App\Http\Controllers\Api\GrafikApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. ROUTE PUBLIC (Bisa diakses tanpa Login) ---

// Test Koneksi
Route::get('/test-api', function () {
    return 'API OK';
});

// Auth Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// --- 2. ROUTE PRIVATE (Harus Login / Punya Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route Fitur Utama (Sebaiknya dipindah ke sini agar aman)
    Route::apiResource('barang', BarangApiController::class);
    Route::apiResource('suppliers', SupplierApiController::class);
    Route::apiResource('pengeluaran', PengeluaranApiController::class);
    Route::apiResource('hutang', HutangPiutangApiController::class);
    Route::patch('hutang/{id}/lunas', [HutangPiutangApiController::class, 'selesai']);

    // Route User Profile (Opsional, untuk cek siapa yang login)
    Route::get('/user', function (Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [DashboardApiController::class, 'index']);
    Route::apiResource('pembelian', PembelianApiController::class);
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanApiController::class, 'index']); 
        
        Route::get('/stok', [LaporanApiController::class, 'stok']);
        
        Route::get('/laba-rugi', [LaporanApiController::class, 'labaRugi']);
    });
});
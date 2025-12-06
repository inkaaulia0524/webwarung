<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\SupplierApiController;
use App\Http\Controllers\Api\PengeluaranApiController;

//route test api
Route::get('/test-api', function () {
    return 'API OK';
});

//route fitur barang
Route::apiResource('barang', BarangApiController::class);
//route fitur supplier
Route::apiResource('suppliers', SupplierApiController::class);
//route fitur pengeluaran
Route::apiResource('pengeluaran', PengeluaranApiController::class);
//route fitur hutang piutang
Route::apiResource('hutang', App\Http\Controllers\Api\HutangPiutangApiController::class);
Route::patch('hutang/{id}/lunas', [App\Http\Controllers\Api\HutangPiutangApiController::class, 'selesai']); // custom route untuk menandai hutang sebagai lunas
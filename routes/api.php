<?php
use App\Http\Controllers\Api\BarangApiController;
use Illuminate\Support\Facades\Route;

//route test api
Route::get('/test-api', function () {
    return 'API OK';
});

//route ditambahkan disni ya guys
Route::apiResource('barang', BarangApiController::class);

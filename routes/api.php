<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\LokasiController;
use App\Http\Controllers\Api\PenggunaController;
use App\Http\Controllers\Api\KondisiBarangController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;
use App\Http\Controllers\Api\PetugasController;

// Public
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Role Admin
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('petugas', PetugasController::class);
        Route::apiResource('kategori', KategoriController::class);
        Route::apiResource('lokasi', LokasiController::class);
        Route::apiResource('pengguna', PenggunaController::class);
        Route::apiResource('kondisi-barang', KondisiBarangController::class);
    });

    // // Role Petugas
    // Route::middleware('role:petugas')->group(function () {
    //     Route::apiResource('barang', BarangController::class);
    //     Route::apiResource('peminjaman', PeminjamanController::class);
    //     Route::apiResource('pengembalian', PengembalianController::class);
    // });

});

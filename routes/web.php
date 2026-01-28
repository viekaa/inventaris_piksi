<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BidangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // MASTER DATA
    Route::resource('bidang', BidangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);

    // CRUD PETUGAS DI DALAM BIDANG
    Route::post('bidang/{bidang}/petugas',
        [BidangController::class,'storePetugas']
    )->name('bidang.petugas.store');

    Route::delete('petugas/{user}',
        [BidangController::class,'destroyPetugas']
    )->name('bidang.petugas.destroy');
});


/*
|--------------------------------------------------------------------------
| PETUGAS DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:petugas'])->group(function () {

    // Dashboard utama petugas
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    // Sub dashboard per bidang
    Route::get('/petugas/akademik', fn() => view('petugas.akademik'))->name('petugas.akademik');
    Route::get('/petugas/keuangan', fn() => view('petugas.keuangan'))->name('petugas.keuangan');
    Route::get('/petugas/kemahasiswaan', fn() => view('petugas.kemahasiswaan'))->name('petugas.kemahasiswaan');
    Route::get('/petugas/umum', fn() => view('petugas.umum'))->name('petugas.umum');
});


/*
|--------------------------------------------------------------------------
| DATA OPERASIONAL (ADMIN + PETUGAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin,petugas'])->group(function () {

    Route::resource('barang', BarangController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class);

});

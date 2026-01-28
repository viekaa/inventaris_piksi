<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    BidangController,
    BarangController,
    PeminjamanController,
    PengembalianController,
    KategoriController,
    LokasiController
};

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
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Master Data
        Route::resource('bidang', BidangController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('lokasi', LokasiController::class);

        // Petugas dalam Bidang
        Route::post('bidang/{bidang}/petugas',
            [BidangController::class, 'storePetugas']
        )->name('bidang.petugas.store');

        Route::delete('petugas/{user}',
            [BidangController::class, 'destroyPetugas']
        )->name('bidang.petugas.destroy');
});


/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('petugas.dashboard');
        })->name('dashboard');

        Route::get('/akademik', fn () => view('petugas.akademik'))->name('akademik');
        Route::get('/keuangan', fn () => view('petugas.keuangan'))->name('keuangan');
        Route::get('/kemahasiswaan', fn () => view('petugas.kemahasiswaan'))->name('kemahasiswaan');
        Route::get('/umum', fn () => view('petugas.umum'))->name('umum');
});


/*
|--------------------------------------------------------------------------
| OPERASIONAL (ADMIN + PETUGAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    Route::resource('barang', BarangController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class);
});

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
| Admin hanya boleh LIHAT (index + show)
*/
Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('bidang', BidangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);

    // ===============================
    // ADMIN BISA LIHAT DATA OPERASIONAL
    // ===============================
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian.index');

    Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show'])
        ->name('pengembalian.show');
});



/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
| Petugas = FULL CRUD
*/
Route::middleware(['auth','role:petugas'])
->prefix('petugas')
->name('petugas.')
->group(function () {

    // Dashboard bidang
    Route::get('/akademik', fn () => view('petugas.akademik'))->name('akademik');
    Route::get('/keuangan', fn () => view('petugas.keuangan'))->name('keuangan');
    Route::get('/kemahasiswaan', fn () => view('petugas.kemahasiswaan'))->name('kemahasiswaan');
    Route::get('/umum', fn () => view('petugas.umum'))->name('umum');

    // OPERASIONAL FULL
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class);
});


/*
|--------------------------------------------------------------------------
| BARANG (ADMIN + PETUGAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin,petugas'])
->group(function () {
    Route::resource('barang', BarangController::class);
});


/*
|--------------------------------------------------------------------------
| AKSI KHUSUS
|--------------------------------------------------------------------------
*/
Route::post('/peminjaman/{peminjaman}/kembalikan',
    [PeminjamanController::class, 'kembalikan']
)->name('peminjaman.kembalikan');

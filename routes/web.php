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

        // Admin hanya boleh MELIHAT data operasional
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
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

        Route::get('/akademik', fn () => view('petugas.akademik'))->name('akademik');
        Route::get('/keuangan', fn () => view('petugas.keuangan'))->name('keuangan');
        Route::get('/kemahasiswaan', fn () => view('petugas.kemahasiswaan'))->name('kemahasiswaan');
        Route::get('/umum', fn () => view('petugas.umum'))->name('umum');

        // Operasional hanya untuk petugas (FULL CRUD)
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);
});


/*
|--------------------------------------------------------------------------
| OPERASIONAL UMUM (ADMIN + PETUGAS)
|--------------------------------------------------------------------------
| Barang boleh dilihat semua, tapi CRUD tetap kamu kontrol di controller
*/
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::resource('barang', BarangController::class);
});
Route::post('/peminjaman/{peminjaman}/kembalikan',
    [PeminjamanController::class, 'kembalikan']
)->name('peminjaman.kembalikan');

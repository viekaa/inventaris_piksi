<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    BidangController,
    BarangController,
    PeminjamanController,
    PengembalianController,
    KategoriController,
    LokasiController,
    PetugasController,
    DashboardController
};

Auth::routes();

Route::get('/', fn () => view('auth.login'))->name('login');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin', 'status'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('bidang',   BidangController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('lokasi',   LokasiController::class);

        // Aktifkan harus SEBELUM resource agar tidak tertimpa
        Route::put('pengguna/{user}/aktifkan', [PetugasController::class, 'aktifkan'])->name('petugas.aktifkan');
        Route::resource('petugas', PetugasController::class)->parameters(['petugas' => 'user']);

        Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
            Route::get('/export-pdf',     [PeminjamanController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/',               [PeminjamanController::class, 'index'])->name('index');
            Route::get('/{peminjaman}',   [PeminjamanController::class, 'show'])->name('show');
        });

        Route::prefix('pengembalian')->name('pengembalian.')->group(function () {
            Route::get('/export-pdf',     [PengembalianController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/',               [PengembalianController::class, 'index'])->name('index');
            Route::get('/{pengembalian}', [PengembalianController::class, 'show'])->name('show');
        });
    });


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas', 'status'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

        Route::get('/akademik',      fn () => view('petugas.akademik'))->name('akademik');
        Route::get('/keuangan',      fn () => view('petugas.keuangan'))->name('keuangan');
        Route::get('/kemahasiswaan', fn () => view('petugas.kemahasiswaan'))->name('kemahasiswaan');
        Route::get('/umum',          fn () => view('petugas.umum'))->name('umum');

        Route::get('/peminjaman/export-pdf',   [PeminjamanController::class,   'exportPdf'])->name('peminjaman.export-pdf');
        Route::get('/pengembalian/export-pdf', [PengembalianController::class, 'exportPdf'])->name('pengembalian.export-pdf');

        Route::resource('peminjaman',   PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);
    });


/*
|--------------------------------------------------------------------------
| BARANG (ADMIN + PETUGAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,petugas'])
    ->group(function () {
        Route::get('/barang/export-pdf', [BarangController::class, 'exportPdf'])->name('barang.export-pdf');
        Route::resource('barang', BarangController::class);
    });


/*
|--------------------------------------------------------------------------
| AKSI KHUSUS
|--------------------------------------------------------------------------
*/
Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
    ->name('peminjaman.kembalikan');

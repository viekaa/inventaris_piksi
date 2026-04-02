<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Spesifik ke sidebar saja, bukan semua view
        View::composer('layouts.backend.sidebar', function ($view) {
            $jumlahPerhatian = 0;
            if (Auth::check() && Auth::user()->role === 'admin') {
                $jumlahPerhatian = Barang::whereIn('kondisi', ['rusak', 'perlu_perbaikan'])->count();
            }
            $view->with('jumlahPerhatian', $jumlahPerhatian);
        });
    }
}

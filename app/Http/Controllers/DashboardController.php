<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if ($user->role == 'admin') {
        $barang = Barang::count();
        $peminjaman = Peminjaman::count();
        $pengembalian = Pengembalian::count();
        $stokHabis = Barang::where('stok','<=',5)->count();
    } else {
        $barang = Barang::where('bidang_id', $user->bidang_id)->count();
        $peminjaman = Peminjaman::where('bidang_id', $user->bidang_id)->count();

        $pengembalian = Pengembalian::whereHas('peminjaman', function($q) use ($user){
            $q->where('bidang_id', $user->bidang_id);
        })->count();

        $stokHabis = Barang::where('bidang_id', $user->bidang_id)
                           ->where('stok','<=',5)
                           ->count();
    }

    return view('dashboard.index', compact('barang','peminjaman','pengembalian','stokHabis'));
}

}

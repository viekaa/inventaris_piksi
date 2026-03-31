<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bidang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik atas — 4 query ringan
        $totalBarang       = Barang::count();
        $totalPeminjaman   = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();
        $stokMenipis       = Barang::where('stok', '<=', 5)->count();

        // Kondisi barang — 1 query digroup
        $kondisi = Barang::selectRaw('kondisi, count(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $jmlBaik           = $kondisi['baik'] ?? 0;
        $jmlPerluPerbaikan = $kondisi['perlu_perbaikan'] ?? 0;
        $jmlRusak          = $kondisi['rusak'] ?? 0;

        // Statistik barang per bidang — 1 query
        $jumlahPerBidang = Barang::selectRaw('bidang_id, count(*) as jumlah, SUM(CASE WHEN stok <= 5 THEN 1 ELSE 0 END) as stok_menipis')
            ->groupBy('bidang_id')
            ->get()
            ->keyBy('bidang_id');

        // Statistik peminjaman per bidang — 2 query pakai join
        $dipinjamPerBidang = Peminjaman::selectRaw('barangs.bidang_id, count(*) as total')
            ->join('barangs', 'peminjamans.barang_id', '=', 'barangs.id')
            ->where('peminjamans.status', 'dipinjam')
            ->groupBy('barangs.bidang_id')
            ->get()
            ->keyBy('bidang_id');

        $dikembalikanPerBidang = Peminjaman::selectRaw('barangs.bidang_id, count(*) as total')
            ->join('barangs', 'peminjamans.barang_id', '=', 'barangs.id')
            ->where('peminjamans.status', 'dikembalikan')
            ->groupBy('barangs.bidang_id')
            ->get()
            ->keyBy('bidang_id');

        // Gabungkan per bidang
        $bidangs    = Bidang::all();
        $statBidang = $bidangs->map(function ($bidang) use ($jumlahPerBidang, $dipinjamPerBidang, $dikembalikanPerBidang) {
            return [
                'nama'         => $bidang->nama_bidang,
                'jumlah'       => $jumlahPerBidang[$bidang->id]->jumlah ?? 0,
                'stokMenipis'  => $jumlahPerBidang[$bidang->id]->stok_menipis ?? 0,
                'dipinjam'     => $dipinjamPerBidang[$bidang->id]->total ?? 0,
                'dikembalikan' => $dikembalikanPerBidang[$bidang->id]->total ?? 0,
            ];
        });

        // Barang stok menipis
        $barangHabis = Barang::where('stok', '<=', 5)
            ->with('bidang', 'lokasi')
            ->latest()
            ->take(5)
            ->get();

        // Aktivitas terbaru
        $recentPeminjaman = Peminjaman::with('barang.bidang')
            ->latest()
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalBarang', 'totalPeminjaman', 'totalPengembalian', 'stokMenipis',
            'jmlBaik', 'jmlPerluPerbaikan', 'jmlRusak',
            'statBidang', 'barangHabis', 'recentPeminjaman'
        ));
    }
}

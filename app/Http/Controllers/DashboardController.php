<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bidang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\PengembalianDetail;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang       = Barang::count();
        $stokMenipis       = Barang::where('stok', '<=', 5)->count();

        // Data Grafik: Ambil dari Stok Master (Baik) dan Detail Pengembalian (Rusak/Perbaikan)
        $jmlBaik           = Barang::sum('stok');
        $jmlRusak          = PengembalianDetail::where('kondisi', 'rusak')->sum('jumlah');
        $jmlPerluPerbaikan = PengembalianDetail::where('kondisi', 'perlu_perbaikan')->sum('jumlah');

        $totalPeminjaman   = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();

        $bidangs = Bidang::where('nama_bidang', '!=', 'Admin')->orderBy('nama_bidang')->get();

        $statBidang = $bidangs->map(function ($bidang) {
            $barangs = Barang::where('bidang_id', $bidang->id);
            $barangIds = $barangs->pluck('id');

            return (object) [
                'id'                 => $bidang->id,
                'nama'               => $bidang->nama_bidang,
                'jumlah'             => $barangs->count(),
                'stokMenipis'        => $barangs->where('stok', '<=', 5)->count(),
                'jmlBaik'            => $barangs->sum('stok'),
                'jmlPerluPerbaikan'  => PengembalianDetail::whereHas('pengembalian.peminjaman', fn($q) => $q->whereIn('barang_id', $barangIds))
                                        ->where('kondisi', 'perlu_perbaikan')->sum('jumlah'),
                'jmlRusak'           => PengembalianDetail::whereHas('pengembalian.peminjaman', fn($q) => $q->whereIn('barang_id', $barangIds))
                                        ->where('kondisi', 'rusak')->sum('jumlah'),
                'dipinjam'           => Peminjaman::whereIn('barang_id', $barangIds)->where('status', 'dipinjam')->count(),
                'dikembalikan'       => Peminjaman::whereIn('barang_id', $barangIds)->where('status', 'dikembalikan')->count(),
            ];
        });

        $barangHabis = Barang::where('stok', '<=', 5)
            ->whereHas('bidang', fn ($q) => $q->where('nama_bidang', '!=', 'Admin'))
            ->with(['bidang:id,nama_bidang', 'lokasi:id,nama_lokasi'])
            ->orderBy('stok')
            ->limit(5)
            ->get()
            ->map(fn ($b) => (object) [
                'nama_barang' => $b->nama_barang,
                'stok'        => $b->stok,
                'nama_bidang' => $b->bidang->nama_bidang ?? '-',
                'nama_lokasi' => $b->lokasi->nama_lokasi ?? '-',
            ]);

        $recentPeminjaman = Peminjaman::with('barang.bidang:id,nama_bidang')->latest()->take(4)->get();

        return view('admin.dashboard', compact(
            'totalBarang', 'totalPeminjaman', 'totalPengembalian', 'stokMenipis',
            'jmlBaik', 'jmlPerluPerbaikan', 'jmlRusak',
            'statBidang', 'barangHabis', 'recentPeminjaman'
        ));
    }
}

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
        // ── Statistik global barang ───────────────────────────────────
        $totalBarang       = Barang::count();
        $stokMenipis       = Barang::where('stok', '<=', 5)->count();
        $jmlBaik           = Barang::where('kondisi', 'baik')->count();
        $jmlRusak          = Barang::where('kondisi', 'rusak')->count();
        $jmlPerluPerbaikan = Barang::where('kondisi', 'perlu_perbaikan')->count();

        $totalPeminjaman   = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();

        // ── Statistik per bidang ──────────────────────────────────────
        $bidangs = Bidang::where('nama_bidang', '!=', 'Admin')
            ->orderBy('nama_bidang')
            ->get();

        $statBidang = $bidangs->map(function ($bidang) {
            $barangs = Barang::where('bidang_id', $bidang->id)->get();

            return (object) [
                'id'                 => $bidang->id,
                'nama'               => $bidang->nama_bidang,
                'jumlah'             => $barangs->count(),
                'stokMenipis'        => $barangs->where('stok', '<=', 5)->count(),
                'jmlBaik'            => $barangs->where('kondisi', 'baik')->count(),
                'jmlPerluPerbaikan'  => $barangs->where('kondisi', 'perlu_perbaikan')->count(),
                'jmlRusak'           => $barangs->where('kondisi', 'rusak')->count(),
                'dipinjam'           => Peminjaman::whereIn('barang_id', $barangs->pluck('id'))
                                            ->where('status', 'dipinjam')->count(),
                'dikembalikan'       => Peminjaman::whereIn('barang_id', $barangs->pluck('id'))
                                            ->where('status', 'dikembalikan')->count(),
            ];
        });

        // ── Barang stok menipis ───────────────────────────────────────
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

        // ── Aktivitas terbaru ─────────────────────────────────────────
        $recentPeminjaman = Peminjaman::with('barang.bidang:id,nama_bidang')
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

<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bidang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Semua count dalam 1 query
        $stats = DB::selectOne('
            SELECT
                COUNT(*) as total_barang,
                SUM(CASE WHEN stok <= 5 THEN 1 ELSE 0 END) as stok_menipis,
                SUM(CASE WHEN kondisi = "baik" THEN 1 ELSE 0 END) as jml_baik,
                SUM(CASE WHEN kondisi = "rusak" THEN 1 ELSE 0 END) as jml_rusak,
                SUM(CASE WHEN kondisi = "perlu_perbaikan" THEN 1 ELSE 0 END) as jml_perlu_perbaikan
            FROM barangs
        ');

        $totalBarang       = $stats->total_barang;
        $stokMenipis       = $stats->stok_menipis;
        $jmlBaik           = $stats->jml_baik;
        $jmlRusak          = $stats->jml_rusak;
        $jmlPerluPerbaikan = $stats->jml_perlu_perbaikan;

        $totalPeminjaman   = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();

        // Stat per bidang: 1 query JOIN semua sekaligus
        $statBidang = DB::select('
            SELECT
                b.id,
                b.nama_bidang as nama,
                COUNT(DISTINCT br.id) as jumlah,
                SUM(CASE WHEN br.stok <= 5 THEN 1 ELSE 0 END) as stokMenipis,
                SUM(CASE WHEN p.status = "dipinjam" THEN 1 ELSE 0 END) as dipinjam,
                SUM(CASE WHEN p.status = "dikembalikan" THEN 1 ELSE 0 END) as dikembalikan
            FROM bidangs b
            LEFT JOIN barangs br ON br.bidang_id = b.id
            LEFT JOIN peminjamans p ON p.barang_id = br.id
            WHERE b.nama_bidang != "Admin"
            GROUP BY b.id, b.nama_bidang
        ');

        // Barang stok menipis: pakai JOIN bukan whereHas
        $barangHabis = DB::select('
            SELECT br.nama_barang, br.stok,
                   bi.nama_bidang, l.nama_lokasi
            FROM barangs br
            LEFT JOIN bidangs bi ON bi.id = br.bidang_id
            LEFT JOIN lokasis l  ON l.id  = br.lokasi_id
            WHERE br.stok <= 5
              AND bi.nama_bidang != "Admin"
            ORDER BY br.created_at DESC
            LIMIT 5
        ');

        // Aktivitas terbaru
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

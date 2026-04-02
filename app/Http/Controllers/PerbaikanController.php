<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        // 2 query dengan eager load kolom yang diperlukan saja
        $rusak = Barang::where('kondisi', 'rusak')
            ->with(['kategori:id,nama_kategori', 'bidang:id,nama_bidang', 'lokasi:id,nama_lokasi'])
            ->latest()
            ->get();

        $perluPerbaikan = Barang::where('kondisi', 'perlu_perbaikan')
            ->with(['kategori:id,nama_kategori', 'bidang:id,nama_bidang', 'lokasi:id,nama_lokasi'])
            ->latest()
            ->get();

        return view('admin.perbaikan.index', compact('rusak', 'perluPerbaikan'));
    }

    public function update(Request $r, Barang $barang)
    {
        $r->validate([
            'kondisi' => 'required|in:baik,rusak,perlu_perbaikan',
        ]);

        $kondisiLama = $barang->kondisi;
        $kondisiBaru = $r->kondisi;

        // Jika diupdate jadi baik → stok +1
        if ($kondisiBaru === 'baik' && $kondisiLama !== 'baik') {
            $barang->increment('stok');
        }

        // Jika dari baik jadi rusak/perlu_perbaikan → stok -1
        if ($kondisiBaru !== 'baik' && $kondisiLama === 'baik' && $barang->stok > 0) {
            $barang->decrement('stok');
        }

        $barang->update(['kondisi' => $kondisiBaru]);

        return response()->json([
            'success' => true,
            'message' => 'Kondisi barang berhasil diperbarui',
            'kondisi' => $kondisiBaru,
        ]);
    }
}

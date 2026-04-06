<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        $perluPerbaikan = Barang::where('kondisi', 'perlu_perbaikan')
            ->with(['kategori:id,nama_kategori', 'bidang:id,nama_bidang', 'lokasi:id,nama_lokasi'])
            ->latest()
            ->get();

        $rusak = Barang::where('kondisi', 'rusak')
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

        // Dari bermasalah → baik: stok bertambah 1 (barang sudah selesai diperbaiki)
        if ($kondisiBaru === 'baik' && $kondisiLama !== 'baik') {
            $barang->increment('stok');
        }

        // Dari baik → bermasalah: stok berkurang 1 (barang ditarik dari stok)
        if ($kondisiBaru !== 'baik' && $kondisiLama === 'baik' && $barang->stok > 0) {
            $barang->decrement('stok');
        }

        $barang->update(['kondisi' => $kondisiBaru]);

        return response()->json([
            'success' => true,
            'message' => 'Kondisi barang berhasil diperbarui'
                       . ($kondisiBaru === 'baik' ? ' dan stok bertambah 1.' : '.'),
            'kondisi' => $kondisiBaru,
        ]);
    }
}

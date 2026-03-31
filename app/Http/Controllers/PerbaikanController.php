<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        $rusak = Barang::where('kondisi', 'rusak')
            ->with(['kategori', 'bidang', 'lokasi'])
            ->latest()
            ->get();

        $perluPerbaikan = Barang::where('kondisi', 'perlu_perbaikan')
            ->with(['kategori', 'bidang', 'lokasi'])
            ->latest()
            ->get();

        return view('admin.perbaikan.index', compact('rusak', 'perluPerbaikan'));
    }

    public function update(Request $r, Barang $barang)
    {
        $r->validate([
            'kondisi' => 'required|in:baik,rusak,perlu_perbaikan',
        ]);

        // Jika diupdate jadi baik, stok otomatis bertambah 1
        if ($r->kondisi === 'baik' && $barang->kondisi !== 'baik') {
            $barang->increment('stok');
        }

        // Jika sebelumnya baik lalu dikembalikan ke rusak/perlu_perbaikan (kasus edit),
        // kurangi stok agar tidak double
        if ($r->kondisi !== 'baik' && $barang->kondisi === 'baik') {
            if ($barang->stok > 0) {
                $barang->decrement('stok');
            }
        }

        $barang->update(['kondisi' => $r->kondisi]);

        return back()->with('ok', 'Kondisi barang berhasil diperbarui');
    }
}

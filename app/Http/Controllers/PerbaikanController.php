<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PengembalianDetail; // Import model detail
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        // Cari barang yang tercatat di riwayat pengembalian sebagai 'perlu_perbaikan'
        $perluPerbaikan = PengembalianDetail::with(['pengembalian.peminjaman.barang.kategori', 'pengembalian.peminjaman.barang.bidang', 'pengembalian.peminjaman.barang.lokasi'])
            ->where('kondisi', 'perlu_perbaikan')
            ->latest()
            ->get();

        // Cari barang yang tercatat di riwayat pengembalian sebagai 'rusak'
        $rusak = PengembalianDetail::with(['pengembalian.peminjaman.barang.kategori', 'pengembalian.peminjaman.barang.bidang', 'pengembalian.peminjaman.barang.lokasi'])
            ->where('kondisi', 'rusak')
            ->latest()
            ->get();

        return view('admin.perbaikan.index', compact('rusak', 'perluPerbaikan'));
    }

    public function update(Request $r, $id)
    {
        $r->validate([
            'kondisi' => 'required|in:baik,rusak,perlu_perbaikan',
        ]);

        // Cari data di tabel detail pengembalian
        $detail = PengembalianDetail::findOrFail($id);
        $barang = $detail->pengembalian->peminjaman->barang;
        $kondisiBaru = $r->kondisi;

        // Jika di-update jadi 'baik', berarti barang sudah diperbaiki/bagus
        if ($kondisiBaru === 'baik') {
            // Tambah stok barang utamanya
            $barang->increment('stok', $detail->jumlah);

            // Karena sudah baik, hapus catatan kerusakannya dari riwayat
            $detail->delete();

            $msg = 'Barang telah diperbaiki dan kembali ke stok.';
        } else {
            // Jika cuma ubah dari rusak ke perlu_perbaikan (atau sebaliknya)
            $detail->update(['kondisi' => $kondisiBaru]);
            $msg = 'Status kondisi berhasil diperbarui.';
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
            'kondisi' => $kondisiBaru,
        ]);
    }
}

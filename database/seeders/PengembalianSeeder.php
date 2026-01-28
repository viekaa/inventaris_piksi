<?php
namespace Database\Seeders;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        $peminjaman = Peminjaman::first();
        if(!$peminjaman) return;

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali' => now(),
            'kondisi_saat_kembali' => 'baik'
        ]);

        $peminjaman->barang->increment('stok', $peminjaman->jumlah);
    }
}

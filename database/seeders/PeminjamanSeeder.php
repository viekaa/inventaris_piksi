<?php
namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $barang = Barang::first();
        if(!$barang) return;

        Peminjaman::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => 'Mahasiswa TI',
            'jumlah' => 2,
            'tgl_pinjam' => now(),
            'tgl_kembali_rencana' => now()->addDays(7),
            'kondisi_saat_pinjam' => 'baik'
        ]);
    }
}

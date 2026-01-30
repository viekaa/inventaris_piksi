<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Jurusan;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $barang = Barang::first();

        // Ambil jurusan pertama yang ada (pasti ada karena sudah diseed)
        $jurusan = Jurusan::first();

        if(!$barang || !$jurusan){
            return; // safety, biar tidak error
        }

        Peminjaman::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => 'Mahasiswa TI',
            'npm' => '2304050001',
            'jurusan_id' => $jurusan->id,
            'angkatan' => 2023,
            'jumlah' => 2,
            'tgl_pinjam' => now(),
            'tgl_kembali_rencana' => now()->addDays(7),
            'kondisi_saat_pinjam' => 'baik'
        ]);
    }
}

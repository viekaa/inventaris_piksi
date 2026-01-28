<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Bidang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::firstOrCreate(['nama_kategori'=>'Hardware']);
        $lokasi   = Lokasi::firstOrCreate(['nama_lokasi'=>'Lab CBT']);
        $bidang   = Bidang::firstOrCreate(['nama_bidang'=>'Umum']);

        Barang::firstOrCreate([
            'nama_barang'=>'Laptop Inventaris'
        ],[
            'kategori_id'=>$kategori->id,
            'lokasi_id'=>$lokasi->id,
            'bidang_id'=>$bidang->id,
            'jumlah_total'=>10,
            'stok'=>10,
            'kondisi'=>'baik'
        ]);
    }
}

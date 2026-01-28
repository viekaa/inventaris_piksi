<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::create(['nama_kategori'=>'Hardware']);
        Kategori::create(['nama_kategori'=>'Perlengkapan']);
        Kategori::create(['nama_kategori'=>'ATK']);
    }
}

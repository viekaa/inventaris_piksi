<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        Lokasi::create(['nama_lokasi'=>'Gudang Penyimpanan']);
        Lokasi::create(['nama_lokasi'=>'Hardware']);
        Lokasi::create(['nama_lokasi'=>'Front Office']);
        Lokasi::create(['nama_lokasi'=>'Akademik']);
        Lokasi::create(['nama_lokasi'=>'Umum']);
    }
}

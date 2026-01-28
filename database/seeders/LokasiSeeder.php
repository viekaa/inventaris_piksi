<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        Lokasi::create(['nama_lokasi'=>'Lab CMC']);
        Lokasi::create(['nama_lokasi'=>'Lab CBT']);
        Lokasi::create(['nama_lokasi'=>'Lab 302']);
    }
}

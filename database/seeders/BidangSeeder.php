<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        $data = ['Umum','Akademik','Keuangan','Kemahasiswaan'];

        foreach($data as $b){
            Bidang::firstOrCreate(['nama_bidang'=>$b]);
        }
    }
}

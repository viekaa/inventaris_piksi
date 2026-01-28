<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $umum = Bidang::firstOrCreate(['nama_bidang'=>'Umum']);
        $akd  = Bidang::firstOrCreate(['nama_bidang'=>'Akademik']);
        $keu  = Bidang::firstOrCreate(['nama_bidang'=>'Keuangan']);
        $kema = Bidang::firstOrCreate(['nama_bidang'=>'Kemahasiswaan']);

        User::firstOrCreate(['email'=>'admin@admin.com'],[
            'name'=>'Giffari D.R',
            'password'=>Hash::make('admin123'),
            'role'=>'admin',
            'bidang_id'=>$umum->id
        ]);

        User::firstOrCreate(['email'=>'akademik@piksi.com'],[
            'name'=>'Ai Susi',
            'password'=>Hash::make('akademik123'),
            'role'=>'petugas',
            'bidang_id'=>$akd->id
        ]);

        User::firstOrCreate(['email'=>'keuangan@piksi.com'],[
            'name'=>'Intan Mutiara',
            'password'=>Hash::make('keuangan123'),
            'role'=>'petugas',
            'bidang_id'=>$keu->id
        ]);

        User::firstOrCreate(['email'=>'kemahasiswaan@piksi.com'],[
            'name'=>'Sri Wahyuningsih',
            'password'=>Hash::make('kema123'),
            'role'=>'petugas',
            'bidang_id'=>$kema->id
        ]);
    }
}

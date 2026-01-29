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
        // Pastikan semua bidang ada
        $umum = Bidang::updateOrCreate(['nama_bidang' => 'Umum']);
        $akd  = Bidang::updateOrCreate(['nama_bidang' => 'Akademik']);
        $keu  = Bidang::updateOrCreate(['nama_bidang' => 'Keuangan']);
        $kema = Bidang::updateOrCreate(['nama_bidang' => 'Kemahasiswaan']);

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Giffari D.R',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'bidang_id' => $umum->id,
            ]
        );

        // Petugas Akademik
        User::updateOrCreate(
            ['email' => 'akademik@piksi.com'],
            [
                'name' => 'Ai Susi',
                'password' => Hash::make('akademik123'),
                'role' => 'petugas',
                'bidang_id' => $akd->id,
            ]
        );

        // Petugas Keuangan
        User::updateOrCreate(
            ['email' => 'keuangan@piksi.com'],
            [
                'name' => 'Intan Mutiara',
                'password' => Hash::make('keuangan123'),
                'role' => 'petugas',
                'bidang_id' => $keu->id,
            ]
        );

        // Petugas Kemahasiswaan
        User::updateOrCreate(
            ['email' => 'kemahasiswaan@piksi.com'],
            [
                'name' => 'Sri Wahyuningsih',
                'password' => Hash::make('kema123'),
                'role' => 'petugas',
                'bidang_id' => $kema->id,
            ]
        );
    }
}

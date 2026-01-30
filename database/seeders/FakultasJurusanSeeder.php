<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasJurusanSeeder extends Seeder
{
    public function run(): void
    {
        // ===== FAKULTAS =====
        $feb = DB::table('fakultas')->insertGetId([
            'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis'
        ]);

        $fkes = DB::table('fakultas')->insertGetId([
            'nama_fakultas' => 'Fakultas Kesehatan'
        ]);

        $fit = DB::table('fakultas')->insertGetId([
            'nama_fakultas' => 'Fakultas IT dan Komputer'
        ]);

        $korps = DB::table('fakultas')->insertGetId([
            'nama_fakultas' => 'Korps Taruna'
        ]);

        // ===== JURUSAN FEB =====
        DB::table('jurusans')->insert([
            ['fakultas_id'=>$feb,'nama_jurusan'=>'D3 Administrasi Keuangan (AKE)'],
            ['fakultas_id'=>$feb,'nama_jurusan'=>'D3 Komputerisasi Akuntansi'],
            ['fakultas_id'=>$feb,'nama_jurusan'=>'D3 Manajemen Bisnis'],
            ['fakultas_id'=>$feb,'nama_jurusan'=>'D4 Bisnis Digital'],
        ]);

        // ===== JURUSAN KESEHATAN =====
        DB::table('jurusans')->insert([
            ['fakultas_id'=>$fkes,'nama_jurusan'=>'D3 Rekam Medis dan Informasi Kesehatan (RMIK)'],
            ['fakultas_id'=>$fkes,'nama_jurusan'=>'D3 Teknologi Laboratorium Medik (TLM)'],
            ['fakultas_id'=>$fkes,'nama_jurusan'=>'D3 Farmasi'],
            ['fakultas_id'=>$fkes,'nama_jurusan'=>'D3 Fisioterapi'],
            ['fakultas_id'=>$fkes,'nama_jurusan'=>'D4 Manajemen Rumah Sakit'],
        ]);

        // ===== JURUSAN IT =====
        DB::table('jurusans')->insert([
            ['fakultas_id'=>$fit,'nama_jurusan'=>'D3 Manajemen Informatika (MIF)'],
            ['fakultas_id'=>$fit,'nama_jurusan'=>'D3 Teknik Informatika (TIK)'],
            ['fakultas_id'=>$fit,'nama_jurusan'=>'D3 Komputer Multimedia'],
            ['fakultas_id'=>$fit,'nama_jurusan'=>'D4 Produksi Media'],
        ]);

        // ===== KORPS TARUNA =====
        DB::table('jurusans')->insert([
            ['fakultas_id'=>$korps,'nama_jurusan'=>'Korps Taruna'],
        ]);
    }
}

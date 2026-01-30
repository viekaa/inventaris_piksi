<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Bidang;
use App\Models\Barang;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            LokasiSeeder::class,
            BarangSeeder::class,
            PeminjamanSeeder::class,
            PengembalianSeeder::class,
            BidangSeeder::class,
            FakultasJurusanSeeder::class,

        ]);
    }
}

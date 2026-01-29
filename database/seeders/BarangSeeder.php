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
        // Kategori
        $hardware     = Kategori::where('nama_kategori','Hardware')->first();
        $perlengkapan = Kategori::where('nama_kategori','Perlengkapan')->first();
        $atk          = Kategori::where('nama_kategori','ATK')->first();

        // Lokasi
        $gudang = Lokasi::firstOrCreate(['nama_lokasi' => 'Gudang Peminjaman']);
        $lab    = Lokasi::firstOrCreate(['nama_lokasi' => 'Lab Komputer']);
        $kelas  = Lokasi::firstOrCreate(['nama_lokasi' => 'Ruang Kelas']);
        $kantor = Lokasi::firstOrCreate(['nama_lokasi' => 'Kantor']);

        $bidangs = Bidang::all();

        foreach ($bidangs as $bidang) {

            $items = match ($bidang->nama_bidang) {

                // ================= UMUM =================
                'Umum' => [
                    ['nama' => 'Laptop Pinjaman', 'kategori' => $hardware, 'lokasi' => $gudang, 'stok' => 8],
                    ['nama' => 'LCD Proyektor',   'kategori' => $hardware, 'lokasi' => $gudang, 'stok' => 6],
                    ['nama' => 'Tripod Kamera',   'kategori' => $perlengkapan, 'lokasi' => $gudang, 'stok' => 10],
                ],

                // ================= AKADEMIK =================
                'Akademik' => [
                    ['nama' => 'Tablet Belajar',    'kategori' => $hardware, 'lokasi' => $lab,   'stok' => 15],
                    ['nama' => 'Pointer Presenter','kategori' => $hardware, 'lokasi' => $kelas, 'stok' => 20],
                    ['nama' => 'Whiteboard Portable','kategori'=> $perlengkapan,'lokasi'=> $kelas,'stok' => 10],
                ],

                // ================= KEUANGAN =================
                'Keuangan' => [
                    ['nama' => 'Scanner Dokumen',  'kategori' => $hardware, 'lokasi' => $kantor, 'stok' => 4],
                    ['nama' => 'Kalkulator Ilmiah','kategori' => $hardware, 'lokasi' => $kantor, 'stok' => 15],
                    ['nama' => 'Map Arsip',        'kategori' => $perlengkapan, 'lokasi' => $kantor, 'stok' => 30],
                ],

                // ================= KEMAHASISWAAN =================
                'Kemahasiswaan' => [
                    ['nama' => 'Seragam Formal Hitam Putih','kategori' => $perlengkapan,'lokasi' => $gudang,'stok' => 120],
                    ['nama' => 'Toga Wisuda',              'kategori' => $perlengkapan,'lokasi' => $gudang,'stok' => 60],
                    ['nama' => 'ID Card Panitia',          'kategori' => $perlengkapan,'lokasi' => $gudang,'stok' => 200],
                    ['nama' => 'Badge & Pin Kegiatan',     'kategori' => $atk,'lokasi' => $gudang,'stok' => 300],
                ],

                default => []
            };

            foreach ($items as $item) {
                Barang::firstOrCreate(
                    [
                        'nama_barang' => $item['nama'],
                        'bidang_id'   => $bidang->id
                    ],
                    [
                        'kategori_id'   => $item['kategori']->id,
                        'lokasi_id'     => $item['lokasi']->id,
                        'jumlah_total' => $item['stok'],
                        'stok'         => $item['stok'],
                        'kondisi'      => 'baik'
                    ]
                );
            }
        }
    }
}

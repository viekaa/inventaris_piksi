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
        $gudang = Lokasi::firstOrCreate(['nama_lokasi' => 'Gudang Penyimpanan']);
        $hw     = Lokasi::firstOrCreate(['nama_lokasi' => 'Hardware']);
        $fo     = Lokasi::firstOrCreate(['nama_lokasi' => 'Front Office']);
        $kantor = Lokasi::firstOrCreate(['nama_lokasi' => 'Akademik']);
        $vip    = Lokasi::firstOrCreate(['nama_lokasi' => 'Umum']);

        $bidangs = Bidang::all();

        foreach ($bidangs as $bidang) {

            $items = match ($bidang->nama_bidang) {

                // ================= UMUM =================
                'Umum' => [
                    ['nama' => 'Laptop Pinjaman', 'kategori' => $hardware, 'lokasi' => $gudang, 'stok' => 10, 'foto' => 'barang/laptop-pinjaman.png'],
                    ['nama' => 'LCD Proyektor',   'kategori' => $hardware, 'lokasi' => $gudang, 'stok' => 8, 'foto' => 'barang/lcd-proyektor.jpg'],
                    ['nama' => 'Tripod Kamera',   'kategori' => $perlengkapan, 'lokasi' => $gudang, 'stok' => 6, 'foto' => 'barang/tripod-kamera.png'],
                    ['nama' => 'Kamera',          'kategori' => $hardware, 'lokasi' => $hw, 'stok' => 5, 'foto' => 'barang/kamera.jpg'],
                    ['nama' => 'Speaker Bluetooth', 'kategori' => $hardware, 'lokasi' => $hw, 'stok' => 12, 'foto' => 'barang/speaker.jpg'],
                ],

                // ================= AKADEMIK =================
                'Akademik' => [
                    ['nama' => 'Tablet Belajar',      'kategori' => $hardware, 'lokasi' => $kantor, 'stok' => 7, 'foto' => 'barang/tablet-belajar.png'],
                    ['nama' => 'Pointer Presenter',   'kategori' => $hardware, 'lokasi' => $kantor, 'stok' => 13, 'foto' => 'barang/pointer-presenter.jpg'],
                    ['nama' => 'Whiteboard Portable', 'kategori' => $perlengkapan, 'lokasi' => $kantor, 'stok' => 5, 'foto' => 'barang/whiteboard.jpg'],
                    ['nama' => 'Spidol Whiteboard',   'kategori' => $atk, 'lokasi' => $kantor, 'stok' => 50, 'foto' => 'barang/spidol.png'],
                ],

                // ================= KEUANGAN =================
                'Keuangan' => [
                    ['nama' => 'Scanner Dokumen',   'kategori' => $hardware, 'lokasi' => $fo, 'stok' => 4, 'foto' => 'barang/scanner-dokumen.png'],
                    ['nama' => 'Kalkulator Ilmiah', 'kategori' => $hardware, 'lokasi' => $fo, 'stok' => 8, 'foto' => 'barang/kalkulator-ilmiah.jpg'],
                    ['nama' => 'Map Arsip',         'kategori' => $perlengkapan, 'lokasi' => $fo, 'stok' => 30, 'foto' => 'barang/map-arsip.png'],
                ],

                // ================= KEMAHASISWAAN =================
                'Kemahasiswaan' => [
                    ['nama' => 'Seragam Taruna',   'kategori' => $perlengkapan, 'lokasi' => $gudang, 'stok' => 300, 'foto' => 'barang/seragam1.png'],
                    ['nama' => 'Stempel Piksi',    'kategori' => $perlengkapan, 'lokasi' => $gudang, 'stok' => 10, 'foto' => 'barang/stempel.jpg'],
                    ['nama' => 'Printer Epson',    'kategori' => $hardware, 'lokasi' => $gudang, 'stok' => 6, 'foto' => 'barang/printer.jpg'],
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
                        'jumlah_total'  => $item['stok'],
                        'stok'          => $item['stok'],
                        'kondisi'       => 'baik',
                        'foto'          => $item['foto'] ?? null
                    ]
                );
            }
        }
    }
}

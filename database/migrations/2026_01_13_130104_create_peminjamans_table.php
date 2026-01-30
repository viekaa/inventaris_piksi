<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->cascadeOnDelete();

            $table->string('nama_peminjam');
            $table->string('npm');

            // 🔑 Relasi ke tabel jurusans
            $table->foreignId('jurusan_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->year('angkatan');

            $table->integer('jumlah');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali_rencana');
            $table->enum('kondisi_saat_pinjam', ['baik', 'rusak', 'perlu_perbaikan']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};

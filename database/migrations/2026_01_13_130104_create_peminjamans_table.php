<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->string('nama_peminjam');
            $table->integer('jumlah');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali_rencana');
            $table->enum('kondisi_saat_pinjam', ['baik', 'rusak','perlu_perbaikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};

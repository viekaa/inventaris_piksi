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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->foreignId('lokasi_id')->constrained('lokasis');
            $table->foreignId('bidang_id')->constrained('bidangs');
            $table->integer('jumlah_total');
            $table->integer('stok');
            $table->enum('kondisi', ['baik', 'rusak','perlu_perbaikan'])->default('baik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};

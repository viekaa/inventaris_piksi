<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjamans')
                ->cascadeOnDelete();

            $table->date('tgl_kembali_real'); // tanggal kembali sebenarnya
            $table->integer('hari_telat')->default(0);
            $table->enum('kondisi_saat_kembali', ['baik','rusak','perlu_perbaikan']);
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};

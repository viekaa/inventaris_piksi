<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengembalian_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengembalian_id')
                ->constrained('pengembalians')
                ->cascadeOnDelete();

            $table->enum('kondisi', ['baik', 'rusak', 'perlu_perbaikan']);
            $table->integer('jumlah');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_details');
    }
};

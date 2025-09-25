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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('buku_id');
            $table->string('judul');
            $table->string('isbn')->unique()->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->integer('stok')->default(0);
            $table->string('kategori')->nullable(); // Bisa juga dibuat FK ke kategoris
            $table->foreignId('penerbit_id')->nullable()->constrained('penerbits', 'penerbit_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};

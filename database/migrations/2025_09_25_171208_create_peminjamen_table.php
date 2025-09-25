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
        Schema::create('peminjamen', function (Blueprint $table) {
                        $table->id('peminjaman_id');
            $table->foreignId('anggota_id')->constrained('anggotas', 'anggota_id')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id')->onDelete('cascade');
            $table->datetime('tanggal_pinjam')->useCurrent();
            $table->datetime('tanggal_kembali')->nullable();
            $table->datetime('tanggal_dikembalikan')->nullable();
            $table->enum('status', ['DIPINJAM', 'DIKEMBALIKAN', 'TERLAMBAT'])->default('DIPINJAM');
            $table->decimal('denda', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};

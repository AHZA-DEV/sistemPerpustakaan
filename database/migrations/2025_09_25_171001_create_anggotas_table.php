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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('anggota_id');
            $table->string('nisn_nim')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('status_keanggotaan', ['AKTIF', 'NONAKTIF', 'SUSPENDED'])->default('AKTIF');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};

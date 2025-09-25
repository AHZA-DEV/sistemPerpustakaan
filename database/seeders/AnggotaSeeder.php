<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Anggota::create([
            'nisn_nim' => '123456789',
            'nama' => 'Budi Santoso',
            'email' => 'budi@student.com',
            'password' => Hash::make('budi123'),
            'alamat' => 'Jl. Contoh No. 123, Jakarta',
            'telepon' => '081234567890',
            'status_keanggotaan' => 'AKTIF',
        ]);

        Anggota::create([
            'nisn_nim' => '987654321',
            'nama' => 'Siti Aminah',
            'email' => 'siti@student.com',
            'password' => Hash::make('siti123'),
            'alamat' => 'Jl. Merdeka No. 456, Bandung',
            'telepon' => '087654321098',
            'status_keanggotaan' => 'AKTIF',
        ]);

        Anggota::create([
            'nisn_nim' => '555666777',
            'nama' => 'Ahmad Susanto',
            'email' => 'ahmad@student.com',
            'password' => Hash::make('ahmad123'),
            'alamat' => 'Jl. Sudirman No. 789, Surabaya',
            'telepon' => '085555666777',
            'status_keanggotaan' => 'NONAKTIF',
        ]);
    }
}

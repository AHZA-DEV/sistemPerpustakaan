<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run()
    {
        // Admin
        Admin::create([
            'nama' => 'Administrator',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
        ]);

        // Kategori
        Kategori::create([
            'nama_kategori' => 'Fiksi',
            'deskripsi' => 'Buku-buku fiksi dan novel'
        ]);

        Kategori::create([
            'nama_kategori' => 'Non-Fiksi',
            'deskripsi' => 'Buku-buku non-fiksi dan referensi'
        ]);

        // Author
        Author::create([
            'nama_author' => 'Andrea Hirata',
            'biografi' => 'Penulis novel Laskar Pelangi',
            'email' => 'andrea@example.com'
        ]);

        // Penerbit
        Penerbit::create([
            'nama_penerbit' => 'Gramedia',
            'alamat' => 'Jakarta',
            'telepon' => '021-12345678',
            'email' => 'info@gramedia.com'
        ]);
    }
}

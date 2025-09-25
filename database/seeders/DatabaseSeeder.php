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
        // Call individual seeders
        $this->call([
            AdminSeeder::class,
            AnggotaSeeder::class,
            KategoriSeeder::class,
            AuthorSeeder::class,
            PenerbitSeeder::class,
        ]);
    }
}

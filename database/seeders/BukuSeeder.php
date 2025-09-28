<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $kategoris = Kategori::all()->pluck('nama_kategori')->toArray();
        $penerbitIds = Penerbit::all()->pluck('penerbit_id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Buku::create([
                'judul' => $faker->sentence(3),
                'isbn' => $faker->isbn13,
                'tahun_terbit' => $faker->year,
                'stok' => $faker->numberBetween(1, 50),
                'kategori' => $faker->randomElement($kategoris),
                'penerbit_id' => $faker->randomElement($penerbitIds),
            ]);
        }
    }
}

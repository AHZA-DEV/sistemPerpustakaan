<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Faker\Factory as Faker;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $categories = [
            'Teknologi',
            'Fiksi',
            'Non-Fiksi',
            'Sejarah',
            'Sains',
            'Ekonomi',
            'Psikologi',
            'Pendidikan',
            'Agama',
            'Seni'
        ];

        foreach ($categories as $category) {
            Kategori::create([
                'nama_kategori' => $category,
                'deskripsi' => $faker->sentence(10, true)
            ]);
        }
    }
}

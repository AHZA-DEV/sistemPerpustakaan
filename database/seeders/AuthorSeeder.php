<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            Author::create([
                'nama_author' => $faker->name,
                'biografi' => $faker->paragraph(3, true),
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}

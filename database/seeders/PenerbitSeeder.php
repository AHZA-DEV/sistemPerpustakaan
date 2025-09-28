<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penerbit;
use Faker\Factory as Faker;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            Penerbit::create([
                'nama_penerbit' => $faker->company . ' Publisher',
                'alamat' => $faker->address,
                'telepon' => $faker->phoneNumber,
                'email' => $faker->unique()->companyEmail,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BukuAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $bukuIds = Buku::all()->pluck('buku_id')->toArray();
        $authorIds = Author::all()->pluck('author_id')->toArray();

        // Create 10 random book-author relationships
        for ($i = 0; $i < 10; $i++) {
            $bukuId = $faker->randomElement($bukuIds);
            $authorId = $faker->randomElement($authorIds);
            
            // Check if the relationship already exists to avoid duplicates
            $exists = DB::table('buku_authors')
                ->where('buku_id', $bukuId)
                ->where('author_id', $authorId)
                ->exists();
                
            if (!$exists) {
                DB::table('buku_authors')->insert([
                    'buku_id' => $bukuId,
                    'author_id' => $authorId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

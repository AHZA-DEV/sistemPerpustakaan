<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama' => 'Administrator',
            'email' => 'admin@perpustakaan.com',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@perpustakaan.com',
            'password' => Hash::make('super123'),
        ]);
    }
}

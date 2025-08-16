<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Baris ini memanggil AdminUserSeeder yang sudah kita buat sebelumnya
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}

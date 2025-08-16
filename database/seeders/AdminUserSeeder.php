<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate untuk mencegah duplikasi jika seeder dijalankan lagi
        User::updateOrCreate(
            [
                'email' => 'admin@kasirageng.com', // Email untuk login admin
            ],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'), // Password default, ganti nanti!
                'role' => 'admin',
            ]
        );
    }
}

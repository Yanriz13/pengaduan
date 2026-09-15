<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@pengaduan.test'],
            [
                'name' => 'Admin Pengaduan',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@pengaduan.test'],
            [
                'name' => 'Warga Contoh',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}

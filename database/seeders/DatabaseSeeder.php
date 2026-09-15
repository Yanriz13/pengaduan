<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pengaduan',
            'email' => 'admin@pengaduan.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Warga Contoh',
            'email' => 'user@pengaduan.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}

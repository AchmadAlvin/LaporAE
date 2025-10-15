<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Aplikasi',
            'email' => 'admin@aksesmadiun.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi@email.com',
            'password' => Hash::make('Budi123'),
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Ahmad Drian',
            'email' => 'ian@email.com',
            'password' => Hash::make('ian123'),
            'role' => 'user',
        ]);
    }
}

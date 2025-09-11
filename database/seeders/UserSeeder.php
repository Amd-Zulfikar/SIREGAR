<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin awal
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('qwerqwer'), // password awal
            'role_id' => 1, // admin
            'is_verified' => true,
        ]);

        // Drafter awal
        User::create([
            'name' => 'Drafter Pertama',
            'email' => 'drafter@gmail.com',
            'password' => Hash::make('qwerqwer'),
            'role_id' => 2, // drafter
            'is_verified' => true,
        ]);

        // Checker awal
        User::create([
            'name' => 'Checker Pertama',
            'email' => 'checker@gmail.com',
            'password' => Hash::make('qwerqwer'),
            'role_id' => 3, // checker
            'is_verified' => true,
        ]);
    }
}

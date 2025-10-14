<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
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
                'name' => 'Support',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('qwerqwer'),
                'role_id' => 1,
                'email_verification_code' => Str::random(64),
                'is_verified' => true,
                'remember_token' => Str::random(10),
                'status' => 1, // 1 untuk aktif
                'created_at' => now(),
                'updated_at' => now(),
        ]);

        // Drafter awal
        // User::create([
        //     'name' => 'Drafter Pertama',
        //     'email' => 'drafter@gmail.com',
        //     'password' => Hash::make('qwerqwer'),
        //     'role_id' => 2, // drafter
        //     'is_verified' => true,
        // ]);

        // Checker awal
        // User::create([
        //     'name' => 'Checker Pertama',
        //     'email' => 'checker@gmail.com',
        //     'password' => Hash::make('qwerqwer'),
        //     'role_id' => 3, // checker
        //     'is_verified' => true,
        // ]);
    }
}

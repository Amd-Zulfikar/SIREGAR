<?php

namespace Database\Seeders;

use App\Models\Admin\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat role awal: admin, drafter, checker
        Role::insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'drafter', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'checker', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

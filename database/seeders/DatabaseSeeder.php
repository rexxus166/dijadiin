<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Admin Refactory',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        // Regular User
        User::factory()->create([
            'name' => 'Refactory',
            'email' => 'refactory@gmail.com',
            'role' => 'user',
        ]);
    }
}

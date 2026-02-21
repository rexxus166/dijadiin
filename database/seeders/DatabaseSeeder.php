<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User - pakai create() langsung, tidak butuh Faker
        User::create([
            'name' => 'Admin Poliwindra',
            'email' => 'admin@dijadiin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Regular User
        User::create([
            'name' => 'User Poliwindra',
            'email' => 'user@dijadiin.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}

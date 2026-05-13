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
        // Create a default admin user for initial access
        // IMPORTANT: Change these credentials after first login!
        User::firstOrCreate(
            ['email' => 'admin@restaurant.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('AdminPassword123'),
                'email_verified_at' => now(),
            ]
        );

        // Optional: Create a demo user for testing
        // Uncomment if needed
        // User::firstOrCreate(
        //     ['email' => 'demo@restaurant.local'],
        //     [
        //         'name' => 'Demo User',
        //         'password' => Hash::make('DemoPassword123'),
        //         'email_verified_at' => now(),
        //     ]
        // );
    }
}


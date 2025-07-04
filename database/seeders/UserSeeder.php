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
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@organi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'subscription_status' => 'active',
            'expires_at' => now()->addYear(),
        ]);

        // Premium users
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@example.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'subscription_status' => 'active',
            'expires_at' => now()->addMonths(6),
        ]);

        User::create([
            'name' => 'Michael Chen',
            'email' => 'michael.chen@example.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'subscription_status' => 'active',
            'expires_at' => now()->addMonths(3),
        ]);

        User::create([
            'name' => 'Emma Williams',
            'email' => 'emma.williams@example.com',
            'password' => Hash::make('password'),
            'role' => 'premium',
            'subscription_status' => 'expired',
            'expires_at' => now()->subDays(30),
        ]);

        // Regular users
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'inactive',
            'expires_at' => null,
        ]);

        User::create([
            'name' => 'Lisa Anderson',
            'email' => 'lisa.anderson@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'inactive',
            'expires_at' => null,
        ]);

        User::create([
            'name' => 'David Rodriguez',
            'email' => 'david.rodriguez@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'inactive',
            'expires_at' => null,
        ]);

        User::create([
            'name' => 'Jennifer Kim',
            'email' => 'jennifer.kim@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'cancelled',
            'expires_at' => now()->addDays(15),
        ]);

        User::create([
            'name' => 'Robert Taylor',
            'email' => 'robert.taylor@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'inactive',
            'expires_at' => null,
        ]);

        User::create([
            'name' => 'Amanda Brown',
            'email' => 'amanda.brown@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_status' => 'inactive',
            'expires_at' => null,
        ]);
    }
}

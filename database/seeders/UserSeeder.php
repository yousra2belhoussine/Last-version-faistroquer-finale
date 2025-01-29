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
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@faistroquer.fr',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'type' => 'admin',
        ]);

        // Create professional users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "Professional User {$i}",
                'email' => "pro{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'type' => 'professional',
            ]);
        }

        // Create regular users
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'type' => 'particular',
            ]);
        }

        // Create some unverified users
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Unverified User {$i}",
                'email' => "unverified{$i}@example.com",
                'password' => Hash::make('password'),
                'type' => 'particular',
            ]);
        }
    }
} 
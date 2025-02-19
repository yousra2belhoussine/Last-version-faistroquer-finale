<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run()
    {
        // Créer un admin
        User::create([
            'name' => 'Admin Test',
            'email' => 'admintest@test.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Créer un utilisateur normal
        User::create([
            'name' => 'User Test',
            'email' => 'usertest@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Créer un utilisateur professionnel
        User::create([
            'name' => 'Pro Test',
            'email' => 'protest@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'type' => 'professional',
            'email_verified_at' => now(),
        ]);
    }
} 
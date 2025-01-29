<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Créer un utilisateur administrateur';

    public function handle()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@faistroquer.fr',
            'password' => Hash::make('Admin@123456'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->info('Administrateur créé avec succès!');
        $this->info('Email: admin@faistroquer.fr');
        $this->info('Mot de passe: Admin@123456');
    }
} 
<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {email} {password}';
    protected $description = 'Crée un nouvel utilisateur administrateur';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Vérifie si l'utilisateur existe déjà
        $user = User::where('email', $email)->first();

        if ($user) {
            // Met à jour l'utilisateur existant
            $user->update([
                'is_admin' => true,
                'password' => Hash::make($password)
            ]);
            $this->info("L'utilisateur {$email} a été mis à jour en tant qu'administrateur.");
        } else {
            // Crée un nouvel utilisateur administrateur
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true
            ]);
            $this->info("Un nouvel administrateur a été créé avec l'email {$email}.");
        }
    }
} 
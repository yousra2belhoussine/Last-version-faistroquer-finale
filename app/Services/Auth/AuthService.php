<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $data['type'] ?? 'individual',
            ]);

            if (isset($data['company_name'])) {
                $user->company_name = $data['company_name'];
                $user->siret = $data['siret'];
                $user->save();
            }

            Auth::login($user);

            return $this->success($user, 'Inscription réussie');
        } catch (\Exception $e) {
            return $this->error('L\'inscription a échoué: ' . $e->getMessage());
        }
    }

    public function login(array $credentials)
    {
        try {
            if (!Auth::attempt($credentials)) {
                return $this->error('Email ou mot de passe incorrect');
            }

            $user = Auth::user();
            
            if ($user->isBanned()) {
                return $this->error('Votre compte a été suspendu');
            }

            return $this->success([
                'user' => $user,
            ], 'Connexion réussie');
        } catch (\Exception $e) {
            return $this->error('La connexion a échoué: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            
            return $this->success(null, 'Déconnexion réussie');
        } catch (\Exception $e) {
            return $this->error('La déconnexion a échoué: ' . $e->getMessage());
        }
    }
} 
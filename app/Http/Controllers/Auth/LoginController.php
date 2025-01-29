<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        Log::info('Tentative de connexion pour: ' . $request->email);
        
        $credentials = $this->credentials($request);
        $user = \App\Models\User::where('email', $request->email)->first();
        
        // Vérifier si l'utilisateur est banni
        if ($user && $user->isBanned()) {
            Log::info('Utilisateur banni: ' . $request->email);
            return false;
        }
        
        // Vérifier si l'utilisateur est validé (si nécessaire)
        if ($user && !$user->isValidated()) {
            Log::info('Utilisateur non validé: ' . $request->email);
            return false;
        }

        $attempt = $this->guard()->attempt(
            $credentials, 
            $request->boolean('remember')
        );
        
        Log::info('Résultat de la tentative: ' . ($attempt ? 'succès' : 'échec'));
        
        return $attempt;
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            auth()->logout();
            return redirect()->route('verification.notice');
        }
    }
} 
<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'type' => 'required|in:particular,professional',
            'company_name' => 'required_if:type,professional|string|max:255',
            'siret' => 'required_if:type,professional|string|size:14|unique:users',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'company_name' => $request->company_name,
            'siret' => $request->siret,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'message' => 'Inscription réussie. Veuillez vérifier votre email.',
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());
        
        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return redirect()->intended(route('dashboard'))->with('success', $result['message']);
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout();
        
        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message']]);
        }

        return redirect()->route('home')->with('success', $result['message']);
    }
} 
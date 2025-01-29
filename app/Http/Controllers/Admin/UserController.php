<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtrage par type d'utilisateur
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Recherche par nom ou email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function validatePro(User $user)
    {
        if ($user->type === 'professional') {
            $user->update(['is_validated' => true]);
            return redirect()->back()->with('success', 'Compte professionnel validé avec succès');
        }
        return redirect()->back()->with('error', 'Cette action n\'est valide que pour les comptes professionnels');
    }

    public function restrict(User $user, Request $request)
    {
        $request->validate([
            'duration' => 'required|integer|min:1',
            'reason' => 'required|string|max:500'
        ]);

        $user->update([
            'is_restricted' => true,
            'restriction_end_date' => now()->addDays($request->duration),
            'restriction_reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Utilisateur restreint avec succès');
    }

    public function suspend(User $user, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user->update([
            'is_suspended' => true,
            'suspension_reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Compte suspendu avec succès');
    }

    public function unsuspend(User $user)
    {
        $user->update([
            'is_suspended' => false,
            'suspension_reason' => null
        ]);

        return redirect()->back()->with('success', 'Suspension levée avec succès');
    }
} 
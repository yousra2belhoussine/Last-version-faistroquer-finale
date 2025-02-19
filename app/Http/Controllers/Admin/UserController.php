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

        // Recherche
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->has('role') && $request->role !== '') {
            $query->where('is_admin', $request->role === 'admin');
        }

        // Filtre par statut
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Pagination avec 10 utilisateurs par page
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

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

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
} 
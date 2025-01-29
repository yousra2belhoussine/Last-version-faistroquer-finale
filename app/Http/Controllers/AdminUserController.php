<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query()
            ->with(['badges', 'reviews'])
            ->withCount(['ads', 'transactions', 'propositions']);

        // Apply filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['type', 'search']),
        ]);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load([
            'badges',
            'reviews',
            'ads',
            'transactions',
            'propositions',
            'receivedReviews',
        ]);

        return Inertia::render('Admin/Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'type' => 'required|in:particular,professional',
            'is_active' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Validate a professional user account.
     */
    public function validateProfessional(User $user)
    {
        if ($user->type !== 'professional') {
            return back()->with('error', 'Only professional accounts can be validated.');
        }

        $user->update([
            'is_validated' => true,
            'validated_at' => now(),
        ]);

        // Send notification to user
        $user->notify(new ProfessionalAccountValidated());

        return back()->with('success', 'Professional account validated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Soft delete the user and related data
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
} 
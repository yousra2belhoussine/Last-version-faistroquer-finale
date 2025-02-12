<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', [
            'user' => Auth::user()
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.'
                ]);
            }

            $user->password = Hash::make($validated['password']);
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function badges()
    {
        return view('profile.badges', [
            'user' => Auth::user()
        ]);
    }

    public function updatePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => ['required', 'image', 'max:2048'], // Max 2MB
            ]);

            $user = auth()->user();
            
            \Log::info('Début de la mise à jour de la photo de profil', [
                'user_id' => $user->id,
                'has_file' => $request->hasFile('photo')
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                // Supprimer l'ancienne photo si elle existe
                if ($user->profile_photo_path) {
                    \Log::info('Suppression de l\'ancienne photo', [
                        'old_path' => $user->profile_photo_path
                    ]);
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Stocker la nouvelle photo
                $path = $file->store('profile-photos', 'public');
                \Log::info('Nouvelle photo stockée', [
                    'new_path' => $path,
                    'full_url' => Storage::disk('public')->url($path)
                ]);
                
                // Mettre à jour le chemin de la photo dans la base de données
                $user->profile_photo_path = $path;
                $user->save();

                \Log::info('Photo de profil mise à jour avec succès');
                
                return back()->with('status', 'photo-updated');
            }

            return back()->with('error', 'Aucune photo n\'a été téléchargée.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de la photo de profil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la photo.');
        }
    }
}

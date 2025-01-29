<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'type' => ['required', 'string', 'in:individual,professional'],
            'company_name' => ['required_if:type,professional', 'string', 'max:255'],
            'siret' => ['required_if:type,professional', 'string', 'size:14', 'unique:users'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'type.required' => 'Le type de compte est obligatoire.',
            'type.in' => 'Le type de compte doit être particulier ou professionnel.',
            'company_name.required_if' => 'Le nom de l\'entreprise est obligatoire pour un compte professionnel.',
            'siret.required_if' => 'Le numéro SIRET est obligatoire pour un compte professionnel.',
            'siret.size' => 'Le numéro SIRET doit contenir 14 chiffres.',
            'siret.unique' => 'Ce numéro SIRET est déjà utilisé.',
        ];
    }
} 
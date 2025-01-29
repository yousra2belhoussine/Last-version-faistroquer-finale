<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FAISTROQUER') }} - Réinitialisation du mot de passe</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-[#157e74]">
        <div class="flex min-h-screen flex-col justify-center px-6 py-12 lg:px-8">
            <!-- Logo et titre -->
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER Logo" class="mx-auto h-24 w-auto filter brightness-0 invert">
                <h2 class="mt-6 text-center text-3xl font-bold leading-9 tracking-tight text-white">
                    Réinitialisation du mot de passe
                </h2>
                <p class="mt-2 text-center text-sm text-white/80">
                    Entrez votre adresse email pour recevoir un lien de réinitialisation
                </p>
            </div>

            <!-- Messages de statut -->
            @if (session('status'))
                <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-sm">
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire de réinitialisation -->
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <div class="relative">
                    <div class="absolute -inset-1 bg-white/20 rounded-2xl opacity-25 group-hover:opacity-100 transition duration-200 blur"></div>
                    <div class="relative bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8">
                        <form class="space-y-6" action="{{ route('admin.password.email') }}" method="POST">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-white">Email</label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" autocomplete="email" required 
                                        class="appearance-none block w-full px-3 py-2 border border-white/20 bg-white/10 rounded-lg shadow-sm placeholder-white/60 text-white focus:outline-none focus:ring-white/50 focus:border-white/50 sm:text-sm backdrop-blur-lg"
                                        value="{{ old('email') }}"
                                        placeholder="admin@faistroquer.fr">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bouton d'envoi -->
                            <div>
                                <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-[#157e74] bg-white hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transform transition-all duration-200 hover:scale-[1.02]">
                                    Envoyer le lien de réinitialisation
                                </button>
                            </div>

                            <!-- Retour à la connexion -->
                            <div class="text-center">
                                <a href="{{ route('admin.login') }}" class="text-sm text-white hover:text-white/90 transition-colors">
                                    Retour à la connexion
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 
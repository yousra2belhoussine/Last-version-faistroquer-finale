<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-[#157e74]">
        <div class="relative max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <!-- Logo et titre -->
            <div class="text-center mb-8 animate-fade-in-down">
                <div class="flex flex-col items-center justify-center mb-6">
                    <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER Logo" class="h-24 w-auto filter brightness-0 invert">
                    <div class="mt-4 text-white text-4xl font-bold tracking-wider">FAISTROQUER</div>
                </div>
                <h2 class="text-3xl font-extrabold text-white">
                    Créez votre compte
                </h2>
                <p class="mt-2 text-lg text-white/90">
                    Rejoignez notre communauté d'échange
                </p>
            </div>

            <!-- Formulaire d'inscription -->
            <div class="max-w-md mx-auto">
                <div class="relative">
                    <div class="absolute -inset-1 bg-white/20 rounded-2xl opacity-25 group-hover:opacity-100 transition duration-200 blur"></div>
                    <div class="relative bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl p-8">
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-white">Nom</label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" required 
                                        class="appearance-none block w-full px-3 py-2 border border-white/20 bg-white/10 rounded-lg shadow-sm placeholder-white/60 text-white focus:outline-none focus:ring-white/50 focus:border-white/50 sm:text-sm backdrop-blur-lg"
                                        value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-white">Email</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" required 
                                        class="appearance-none block w-full px-3 py-2 border border-white/20 bg-white/10 rounded-lg shadow-sm placeholder-white/60 text-white focus:outline-none focus:ring-white/50 focus:border-white/50 sm:text-sm backdrop-blur-lg"
                                        value="{{ old('email') }}">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-white">Mot de passe</label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" required 
                                        class="appearance-none block w-full px-3 py-2 border border-white/20 bg-white/10 rounded-lg shadow-sm placeholder-white/60 text-white focus:outline-none focus:ring-white/50 focus:border-white/50 sm:text-sm backdrop-blur-lg">
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-white">Confirmer le mot de passe</label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                                        class="appearance-none block w-full px-3 py-2 border border-white/20 bg-white/10 rounded-lg shadow-sm placeholder-white/60 text-white focus:outline-none focus:ring-white/50 focus:border-white/50 sm:text-sm backdrop-blur-lg">
                                </div>
                            </div>

                            <!-- Bouton d'inscription -->
                            <div>
                                <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-[#157e74] bg-white hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white transform transition-all duration-200 hover:scale-[1.02]">
                                    S'inscrire
                                </button>
                            </div>
                        </form>

                        <!-- Lien vers la connexion -->
                        <div class="mt-6 text-center">
                            <p class="text-sm text-white/80">
                                Déjà inscrit ?
                                <a href="{{ route('login') }}" class="font-medium text-white hover:text-white/90 transition-colors">
                                    Se connecter
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('styles')
    <style>
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 1s ease-out;
        }
    </style>
</body>
</html> 
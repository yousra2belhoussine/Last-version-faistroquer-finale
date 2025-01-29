<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Administration</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-[#157e74] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER Logo" class="h-8 w-auto filter brightness-0 invert">
                        </div>
                        <!-- Menu de navigation -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Tableau de bord</a>
                            <a href="{{ route('admin.users.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Utilisateurs</a>
                            <a href="{{ route('admin.ads.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Annonces</a>
                            <a href="{{ route('admin.exchanges.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Échanges</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Tableau de bord administratif</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Statistiques des utilisateurs -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Utilisateurs</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#157e74]">
                                    {{ \App\Models\User::count() }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-[#157e74] hover:text-[#279078]">
                                Voir tous les utilisateurs →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistiques des annonces -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Annonces</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#157e74]">
                                    {{ \App\Models\Ad::count() }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.ads.index') }}" class="text-sm font-medium text-[#157e74] hover:text-[#279078]">
                                Voir toutes les annonces →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistiques des articles -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-medium text-gray-900">Articles</h3>
                                <div class="mt-1 text-3xl font-semibold text-[#157e74]">
                                    {{ \App\Models\Article::count() }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-[#157e74] hover:text-[#279078]">
                                Voir tous les articles →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activités récentes et statistiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Activités récentes -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Activités récentes</h2>
                        <div class="space-y-4">
                            <!-- Articles en attente -->
                            <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Articles en attente de validation</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>{{ \App\Models\Article::where('status', 'pending')->count() }} articles nécessitent votre attention</p>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-yellow-800 hover:text-yellow-900">
                                                Voir les articles →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dernières annonces -->
                            <div class="border-l-4 border-blue-400 bg-blue-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                            <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Dernières annonces publiées</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>{{ \App\Models\Ad::latest()->take(5)->count() }} nouvelles annonces aujourd'hui</p>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('admin.ads.index') }}" class="text-sm font-medium text-blue-800 hover:text-blue-900">
                                                Voir les annonces →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nouveaux utilisateurs -->
                            <div class="border-l-4 border-green-400 bg-green-50 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">Nouveaux utilisateurs</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>{{ \App\Models\User::whereDate('created_at', today())->count() }} nouveaux utilisateurs aujourd'hui</p>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-green-800 hover:text-green-900">
                                                Voir les utilisateurs →
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques détaillées -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Statistiques détaillées</h2>
                        <div class="space-y-4">
                            <!-- Statistiques des articles -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Articles</h3>
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <span class="block text-2xl font-bold text-green-600">
                                            {{ \App\Models\Article::where('status', 'approved')->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Approuvés</span>
                                    </div>
                                    <div>
                                        <span class="block text-2xl font-bold text-yellow-600">
                                            {{ \App\Models\Article::where('status', 'pending')->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">En attente</span>
                                    </div>
                                    <div>
                                        <span class="block text-2xl font-bold text-red-600">
                                            {{ \App\Models\Article::where('status', 'rejected')->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Rejetés</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistiques des annonces -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Annonces</h3>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <span class="block text-2xl font-bold text-[#157e74]">
                                            {{ \App\Models\Ad::where('status', 'active')->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Actives</span>
                                    </div>
                                    <div>
                                        <span class="block text-2xl font-bold text-gray-600">
                                            {{ \App\Models\Ad::where('status', 'inactive')->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Inactives</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistiques des utilisateurs -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Utilisateurs</h3>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <span class="block text-2xl font-bold text-[#157e74]">
                                            {{ \App\Models\User::where('is_admin', false)->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Utilisateurs</span>
                                    </div>
                                    <div>
                                        <span class="block text-2xl font-bold text-indigo-600">
                                            {{ \App\Models\User::where('is_admin', true)->count() }}
                                        </span>
                                        <span class="text-sm text-gray-500">Administrateurs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
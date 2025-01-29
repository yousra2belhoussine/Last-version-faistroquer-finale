<!-- Navigation -->
<nav class="bg-white border-b border-[#a3cca8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Primary Navigation -->
            <div class="flex items-center flex-1">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="Faistroquer" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-3xl mx-8">
                    <x-search-bar />
                </div>

                <!-- Primary Navigation -->
                <div class="hidden space-x-8 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-[#157e74] hover:text-[#279078]">
                        {{ __('Accueil') }}
                    </a>
                    <a href="{{ route('ads.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-[#279078]">
                        {{ __('Annonces') }}
                    </a>
                    <a href="{{ route('propositions.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-[#279078]">
                        {{ __('Trocs') }}
                    </a>
                </div>
            </div>

            <!-- Secondary Navigation -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @auth
                    <!-- Create Ad Button -->
                    <a href="{{ route('ads.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#3aa17d]">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Déposer une annonce') }}
                    </a>

                    <!-- Messages -->
                    <a href="{{ route('messages.index') }}" class="relative p-2 text-[#157e74] hover:text-[#279078]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        @if(auth()->user()->unreadMessages()->count() > 0)
                            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-[#3aa17d] text-white text-xs text-center">
                                {{ auth()->user()->unreadMessages()->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" class="flex items-center space-x-2 text-[#157e74] hover:text-[#279078]">
                                <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="h-8 w-8 rounded-full object-cover">
                                <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="open" 
                             @click.away="open = false"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-[#a3cca8] ring-opacity-5 focus:outline-none"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    {{ __('Tableau de bord') }}
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    {{ __('Mon profil') }}
                                </a>
                                <a href="{{ route('ads.my-ads') }}" class="block px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    {{ __('Mes annonces') }}
                                </a>
                                <a href="{{ route('profile.badges') }}" class="block px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    {{ __('Mes badges') }}
                                </a>
                                <div class="border-t border-[#a3cca8]"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                        {{ __('Déconnexion') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.articles.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                Administration
                            </a>
                        @endif
                    @endauth
                @else
                    <a href="{{ route('login') }}" class="text-[#157e74] hover:text-[#279078] text-sm font-medium">
                        {{ __('Se connecter') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#279078]">
                        {{ __('S\'inscrire') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#3aa17d]">
                    <span class="sr-only">{{ __('Ouvrir le menu') }}</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden">
        <!-- Mobile Search -->
        <div class="px-4 pt-2 pb-3">
            <x-search-bar />
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 border-[#157e74] text-base font-medium text-[#157e74] bg-[#a3cca8]/10">
                {{ __('Accueil') }}
            </a>
            <a href="{{ route('ads.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-[#157e74] hover:bg-[#a3cca8]/10 hover:border-[#279078]">
                {{ __('Annonces') }}
            </a>
            <a href="{{ route('propositions.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-[#157e74] hover:bg-[#a3cca8]/10 hover:border-[#279078]">
                {{ __('Trocs') }}
            </a>
        </div>

        @auth
            <div class="pt-4 pb-3 border-t border-[#a3cca8]">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-10 w-10 rounded-full">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-[#157e74]">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-[#6dbaaf]">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('Tableau de bord') }}
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('Mon profil') }}
                    </a>
                    <a href="{{ route('ads.my-ads') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('Mes annonces') }}
                    </a>
                    <a href="{{ route('profile.badges') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('Mes badges') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-[#a3cca8]">
                <div class="space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('Se connecter') }}
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        {{ __('S\'inscrire') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav> 
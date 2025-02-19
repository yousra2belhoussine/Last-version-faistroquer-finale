<!-- Navigation -->
<nav x-data="{ mobileMenuOpen: false }" class="bg-gradient-to-r from-[#157e74] to-[#279078] border-b border-[#a3cca8]/20 sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo and Primary Navigation -->
            <div class="flex items-center flex-1">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center transition-transform duration-300 hover:scale-105">
                        <div class="bg-white p-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER" class="h-8 w-auto">
                        </div>
                    </a>
                </div>

                <!-- Primary Navigation -->
                <div class="hidden lg:flex space-x-8 ml-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white hover:text-[#a3cca8] border-b-2 transition-all duration-300 {{ request()->routeIs('home') ? 'border-white' : 'border-transparent' }} hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('Accueil') }}
                    </a>
                    <a href="{{ route('ads.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-[#a3cca8] border-b-2 transition-all duration-300 {{ request()->routeIs('ads.*') ? 'border-white' : 'border-transparent' }} hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        {{ __('Annonces') }}
                    </a>
                    <a href="{{ route('articles.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-[#a3cca8] border-b-2 transition-all duration-300 {{ request()->routeIs('articles.*') ? 'border-white' : 'border-transparent' }} hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        {{ __('Blog') }}
                    </a>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-[#a3cca8] border-b-2 transition-all duration-300 {{ request()->routeIs('admin.*') ? 'border-white' : 'border-transparent' }} hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ __('Administration') }}
                    </a>
                    @endif
                </div>
            </div>

            <!-- Secondary Navigation -->
            <div class="hidden lg:flex lg:items-center lg:ml-6 space-x-4">
                @auth
                    <!-- Messages -->
                    <a href="{{ route('messages.index') }}" class="relative p-2 text-white hover:text-[#a3cca8] transition-all duration-300 hover:scale-110">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        @if(auth()->user()->unreadMessages()->count() > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-5 w-5 bg-white text-[#157e74] text-xs font-bold items-center justify-center">
                                    {{ auth()->user()->unreadMessages()->count() }}
                                </span>
                            </span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    <div class="ml-3 relative z-50" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" @click.away="open = false" class="group flex items-center space-x-2 text-white">
                                <div class="relative">
                                    @if(auth()->user()->profile_photo_path)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                             alt="{{ auth()->user()->name }}" 
                                             class="h-8 w-8 rounded-full object-cover border-2 border-white group-hover:border-[#a3cca8] transition-colors duration-200"
                                             onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-[#157e74] font-semibold border-2 border-white group-hover:bg-[#a3cca8] transition-colors duration-200">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm font-medium group-hover:text-[#a3cca8] transition-colors duration-200">{{ auth()->user()->name }}</span>
                                <svg class="h-5 w-5 group-hover:text-[#a3cca8] transition-colors duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-[#a3cca8] ring-opacity-5 focus:outline-none divide-y divide-gray-100 z-50">
                            <div class="py-1">
                                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ __('Tableau de bord') }}
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Administration') }}
                                </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Mon profil') }}
                                </a>
                                <a href="{{ route('ads.my-ads') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    {{ __('Mes annonces') }}
                                </a>
                                <a href="{{ route('articles.my') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    {{ __('Mes articles') }}
                                </a>
                                <a href="{{ route('profile.badges') }}" class="group flex items-center px-4 py-2 text-sm text-[#157e74] hover:bg-[#a3cca8]/10">
                                    <svg class="mr-3 h-5 w-5 text-[#157e74] group-hover:text-[#279078]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    {{ __('Mes badges') }}
                                </a>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="mr-3 h-5 w-5 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Déconnexion') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-[#a3cca8] text-sm font-medium px-4 py-2 rounded-lg border-2 border-white/30 hover:border-white transition-all duration-300 hover:scale-105">
                        {{ __('Se connecter') }}
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border-2 border-white text-sm font-medium rounded-lg text-[#157e74] bg-white hover:bg-[#a3cca8] hover:border-[#a3cca8] hover:text-white transition-all duration-300 hover:scale-105">
                        {{ __('S\'inscrire') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#a3cca8] hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-colors duration-200">
                    <span class="sr-only">{{ __('Ouvrir le menu') }}</span>
                    <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="lg:hidden bg-white shadow-lg">
        <!-- Mobile Navigation -->
        <div class="border-t border-gray-200">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-[#157e74] text-[#157e74] bg-[#a3cca8]/10' : 'border-transparent text-gray-600 hover:text-[#157e74] hover:bg-[#a3cca8]/10 hover:border-[#157e74]' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Accueil') }}
                </a>
                <a href="{{ route('ads.index') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('ads.*') ? 'border-[#157e74] text-[#157e74] bg-[#a3cca8]/10' : 'border-transparent text-gray-600 hover:text-[#157e74] hover:bg-[#a3cca8]/10 hover:border-[#157e74]' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    {{ __('Annonces') }}
                </a>
                <a href="{{ route('articles.index') }}" class="flex items-center pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('articles.*') ? 'border-[#157e74] text-[#157e74] bg-[#a3cca8]/10' : 'border-transparent text-gray-600 hover:text-[#157e74] hover:bg-[#a3cca8]/10 hover:border-[#157e74]' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    {{ __('Blog') }}
                </a>
            </div>
        </div>

        @auth
            <!-- Mobile User Menu -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="h-10 w-10 rounded-full object-cover border-2 border-[#157e74]">
                        @else
                            <div class="h-10 w-10 rounded-full bg-[#157e74] flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-[#157e74]">{{ auth()->user()->name }}</div>
                        <div class="text-sm font-medium text-[#6dbaaf]">{{ auth()->user()->email }}</div>
                    </div>
                    @if(auth()->user()->unreadMessages()->count() > 0)
                        <div class="ml-auto">
                            <a href="{{ route('messages.index') }}" class="relative inline-flex items-center justify-center p-2">
                                <svg class="h-6 w-6 text-[#157e74]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#157e74] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-[#157e74] text-white text-xs font-bold items-center justify-center">
                                        {{ auth()->user()->unreadMessages()->count() }}
                                    </span>
                                </span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        {{ __('Tableau de bord') }}
                    </a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Administration') }}
                    </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Mon profil') }}
                    </a>
                    <a href="{{ route('ads.my-ads') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ __('Mes annonces') }}
                    </a>
                    <a href="{{ route('articles.my') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        {{ __('Mes articles') }}
                    </a>
                    <a href="{{ route('profile.badges') }}" class="flex items-center px-4 py-2 text-base font-medium text-[#157e74] hover:text-[#279078] hover:bg-[#a3cca8]/10">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        {{ __('Mes badges') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center px-4 py-2 text-base font-medium text-red-600 hover:text-red-700 hover:bg-red-50">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Mobile Auth Links -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="space-y-3 px-4">
                    <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-2 text-base font-medium text-[#157e74] border-2 border-[#157e74]/30 rounded-full hover:text-white hover:bg-[#157e74] transition-all duration-200">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Se connecter') }}
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center px-4 py-2 text-base font-medium text-white bg-[#157e74] rounded-full hover:bg-[#279078] transition-all duration-200">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        {{ __('S\'inscrire') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav> 
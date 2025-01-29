<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <Header />

        <div class="flex">
            <!-- Sidebar (visible on desktop) -->
            <aside class="hidden md:flex md:flex-col md:w-64 bg-white border-r border-gray-200 min-h-screen">
                <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                    <nav class="mt-5 flex-1 px-2 space-y-1">
                        <Link :href="route('dashboard')" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" :class="{ 'bg-gray-100 text-gray-900': route().current('dashboard'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !route().current('dashboard') }">
                            <svg class="mr-3 h-6 w-6" :class="{ 'text-gray-500': route().current('dashboard'), 'text-gray-400 group-hover:text-gray-500': !route().current('dashboard') }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Tableau de bord
                        </Link>

                        <Link :href="route('messages.index')" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" :class="{ 'bg-gray-100 text-gray-900': route().current('messages.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !route().current('messages.*') }">
                            <svg class="mr-3 h-6 w-6" :class="{ 'text-gray-500': route().current('messages.*'), 'text-gray-400 group-hover:text-gray-500': !route().current('messages.*') }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Messages
                        </Link>

                        <Link :href="route('ads.index')" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" :class="{ 'bg-gray-100 text-gray-900': route().current('ads.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !route().current('ads.*') }">
                            <svg class="mr-3 h-6 w-6" :class="{ 'text-gray-500': route().current('ads.*'), 'text-gray-400 group-hover:text-gray-500': !route().current('ads.*') }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Annonces
                        </Link>

                        <Link :href="route('profile.edit')" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md" :class="{ 'bg-gray-100 text-gray-900': route().current('profile.*'), 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': !route().current('profile.*') }">
                            <svg class="mr-3 h-6 w-6" :class="{ 'text-gray-500': route().current('profile.*'), 'text-gray-400 group-hover:text-gray-500': !route().current('profile.*') }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profil
                        </Link>
                    </nav>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1">
                <!-- Page Heading -->
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Flash Messages -->
                <div v-if="$page.props.flash.message" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="rounded-md p-4" :class="{
                        'bg-green-50': $page.props.flash.type === 'success',
                        'bg-red-50': $page.props.flash.type === 'error',
                        'bg-blue-50': $page.props.flash.type === 'info',
                        'bg-yellow-50': $page.props.flash.type === 'warning'
                    }">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg v-if="$page.props.flash.type === 'success'" class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else-if="$page.props.flash.type === 'error'" class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium" :class="{
                                    'text-green-800': $page.props.flash.type === 'success',
                                    'text-red-800': $page.props.flash.type === 'error',
                                    'text-blue-800': $page.props.flash.type === 'info',
                                    'text-yellow-800': $page.props.flash.type === 'warning'
                                }">
                                    {{ $page.props.flash.message }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <main class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </main>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <!-- Company Info -->
                    <div class="col-span-2 md:col-span-1">
                        <img src="/images/logo.svg" alt="FAISTROQUER" class="h-8 w-auto mb-4">
                        <p class="text-gray-500 text-sm">
                            La première plateforme de troc en France.
                        </p>
                    </div>

                    <!-- Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">
                            À propos
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <Link :href="route('pages.how-it-works')" class="text-base text-gray-500 hover:text-gray-900">
                                    Comment ça marche
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('pages.help')" class="text-base text-gray-500 hover:text-gray-900">
                                    Aide
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('pages.contact')" class="text-base text-gray-500 hover:text-gray-900">
                                    Contact
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">
                            Légal
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <Link :href="route('pages.privacy')" class="text-base text-gray-500 hover:text-gray-900">
                                    Confidentialité
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('pages.terms')" class="text-base text-gray-500 hover:text-gray-900">
                                    Conditions d'utilisation
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('pages.gdpr')" class="text-base text-gray-500 hover:text-gray-900">
                                    RGPD
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Social -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">
                            Suivez-nous
                        </h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                    Facebook
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                    Twitter
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-base text-gray-500 hover:text-gray-900">
                                    Instagram
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-8">
                    <p class="text-base text-gray-400 text-center">
                        &copy; {{ new Date().getFullYear() }} FAISTROQUER. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
</script> 
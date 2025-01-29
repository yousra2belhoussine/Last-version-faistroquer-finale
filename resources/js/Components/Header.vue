<template>
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <Link :href="route('home')" class="flex items-center">
                        <img src="/images/logo.svg" alt="FAISTROQUER" class="h-8 w-auto">
                        <span class="ml-2 text-xl font-bold text-gray-900">FAISTROQUER</span>
                    </Link>
                </div>

                <!-- Search Bar (centered) -->
                <div class="hidden md:flex flex-1 justify-center px-8">
                    <div class="w-full max-w-lg relative search-container">
                        <div class="relative">
                            <form @submit.prevent="handleSearch" class="relative">
                                <input type="text" 
                                       v-model="searchQuery"
                                       @input="handleInput"
                                       @focus="showSuggestions = true"
                                       placeholder="Rechercher des annonces..." 
                                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary-500">
                                <div class="absolute left-3 top-2.5">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                    <span class="sr-only">Rechercher</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Search Suggestions -->
                        <div v-if="showSuggestions && searchQuery.length >= 2" 
                             class="absolute w-full mt-1 bg-white rounded-lg shadow-xl border border-gray-200 z-[100] max-h-96 overflow-y-auto">
                            <div v-if="isLoading" class="px-4 py-3 text-sm text-gray-500 text-center">
                                Chargement...
                            </div>
                            <div v-else-if="hasError" class="px-4 py-3 text-sm text-red-500 text-center">
                                Une erreur est survenue
                            </div>
                            <div v-else-if="suggestions.length > 0" class="py-2">
                                <a v-for="suggestion in suggestions" 
                                   :key="suggestion.id"
                                   :href="suggestion.url"
                                   @click="showSuggestions = false"
                                   class="block px-4 py-2 hover:bg-gray-100 transition duration-150">
                                    <div class="text-sm font-medium text-gray-900">{{ suggestion.title }}</div>
                                    <div class="text-xs text-gray-500">{{ suggestion.category }}</div>
                                </a>
                            </div>
                            <div v-else class="px-4 py-3 text-sm text-gray-500 text-center">
                                Aucun résultat
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Post Ad Button -->
                    <Link :href="$page.props.auth.user ? route('ads.create') : route('login')" 
                          class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Déposer une annonce
                    </Link>

                    <!-- Guest Navigation -->
                    <template v-if="!$page.props.auth.user">
                        <Link :href="route('login')" class="text-gray-700 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium">
                            Se connecter
                        </Link>
                        <Link :href="route('register')" class="bg-primary-600 text-white hover:bg-primary-700 px-4 py-2 rounded-md text-sm font-medium">
                            S'inscrire
                        </Link>
                    </template>

                    <!-- Authenticated Navigation -->
                    <template v-else>
                        <!-- Notifications -->
                        <div class="relative">
                            <button @click="toggleNotifications" class="relative text-gray-700 hover:text-primary-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span v-if="unreadNotifications" class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-xs text-white flex items-center justify-center">
                                    {{ unreadNotifications }}
                                </span>
                            </button>
                            <!-- Notifications Dropdown -->
                            <div v-if="showNotifications" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                        <button v-if="notifications.length" class="text-sm text-primary-600 hover:text-primary-800">
                                            Tout marquer comme lu
                                        </button>
                                    </div>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <div v-if="notifications.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                                        Aucune notification
                                    </div>
                                    <div v-else v-for="notification in notifications" :key="notification.id" 
                                         class="px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm text-gray-900">{{ notification.message }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ notification.created_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Messages -->
                        <Link :href="route('messages.index')" class="relative text-gray-700 hover:text-primary-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <span v-if="unreadMessages" class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-xs text-white flex items-center justify-center">
                                {{ unreadMessages }}
                            </span>
                        </Link>

                        <!-- User Menu -->
                        <div class="relative">
                            <button @click="toggleUserMenu" class="flex items-center space-x-2">
                                <img :src="$page.props.auth.user.avatar_path || '/images/default-avatar.png'" 
                                     :alt="$page.props.auth.user.name"
                                     class="h-8 w-8 rounded-full object-cover">
                                <span class="hidden md:block text-sm text-gray-700">{{ $page.props.auth.user.name }}</span>
                            </button>
                            <!-- User Dropdown -->
                            <div v-if="showUserMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <Link :href="route('profile.edit')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mon profil
                                </Link>
                                <Link :href="route('dashboard')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Tableau de bord
                                </Link>
                                <button @click="logout" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Déconnexion
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="toggleMobileMenu" class="text-gray-500 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Search (visible only on mobile) -->
            <div class="md:hidden py-2">
                <form @submit.prevent="handleSearch" class="relative">
                    <input type="text" 
                           v-model="searchQuery"
                           placeholder="Rechercher des annonces..." 
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:border-primary-500">
                    <div class="absolute left-3 top-2.5">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                        <span class="sr-only">Rechercher</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Mobile Menu -->
            <div v-if="showMobileMenu" class="md:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <!-- Guest Navigation -->
                    <template v-if="!$page.props.auth.user">
                        <Link :href="route('login')" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                            Se connecter
                        </Link>
                        <Link :href="route('register')" class="block px-3 py-2 text-base font-medium text-primary-600 hover:bg-gray-50">
                            S'inscrire
                        </Link>
                    </template>

                    <!-- Authenticated Navigation -->
                    <template v-else>
                        <Link :href="route('dashboard')" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                            Tableau de bord
                        </Link>
                        <Link :href="route('messages.index')" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                            Messages
                            <span v-if="unreadMessages" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ unreadMessages }}
                            </span>
                        </Link>
                        <Link :href="route('profile.edit')" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                            Mon profil
                        </Link>
                        <button @click="logout" class="w-full text-left px-3 py-2 text-base font-medium text-red-600 hover:bg-gray-50">
                            Déconnexion
                        </button>
                    </template>
                </div>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const searchQuery = ref('');
const showMobileMenu = ref(false);
const showNotifications = ref(false);
const showUserMenu = ref(false);
const notifications = ref([]);
const unreadNotifications = ref(0);
const unreadMessages = ref(0);
const categories = ref([]);

const filters = ref({
    category: '',
    type: '',
    onlineOnly: false,
    withCountdown: false
});

const showSuggestions = ref(false);
const suggestions = ref([]);
const isLoading = ref(false);
const hasError = ref(false);

const handleInput = debounce(async () => {
    if (searchQuery.value.length >= 2) {
        isLoading.value = true;
        hasError.value = false;
        try {
            const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(searchQuery.value)}`);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            suggestions.value = data;
            showSuggestions.value = true;
        } catch (error) {
            console.error('Error fetching suggestions:', error);
            suggestions.value = [];
            hasError.value = true;
        } finally {
            isLoading.value = false;
        }
    } else {
        suggestions.value = [];
        showSuggestions.value = false;
        hasError.value = false;
    }
}, 300);

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        showSuggestions.value = false;
        console.log('Submitting search:', searchQuery.value.trim());
        window.location.href = `/ads/search?q=${encodeURIComponent(searchQuery.value.trim())}`;
    }
};

const toggleMobileMenu = () => {
    showMobileMenu.value = !showMobileMenu.value;
    if (showMobileMenu.value) {
        showNotifications.value = false;
        showUserMenu.value = false;
    }
};

const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
    if (showNotifications.value) {
        showUserMenu.value = false;
    }
};

const toggleUserMenu = () => {
    showUserMenu.value = !showUserMenu.value;
    if (showUserMenu.value) {
        showNotifications.value = false;
    }
};

const logout = () => {
    router.post(route('logout'));
};

// Close dropdowns when clicking outside
const closeDropdowns = (event) => {
    if (!event.target.closest('.relative')) {
        showNotifications.value = false;
        showUserMenu.value = false;
    }
};

// Close suggestions when clicking outside
const closeSuggestions = (event) => {
    const searchContainer = event.target.closest('.search-container');
    if (!searchContainer) {
        showSuggestions.value = false;
    }
};

onMounted(async () => {
    document.addEventListener('click', closeSuggestions);
    document.addEventListener('click', closeDropdowns);
    
    // Fetch categories
    try {
        const response = await fetch('/api/categories');
        if (response.ok) {
            categories.value = await response.json();
        }
    } catch (error) {
        console.error('Error loading categories:', error);
    }
});

onUnmounted(() => {
    document.removeEventListener('click', closeSuggestions);
    document.removeEventListener('click', closeDropdowns);
});
</script>

<style scoped>
.router-link-active {
    @apply text-primary-600;
}
</style> 
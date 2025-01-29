@props(['placeholder' => "Recherchez des biens, services ou utilisateurs…"])

<div x-data="searchBar()" class="relative flex-1 max-w-3xl">
    <div class="relative">
        <input
            type="text"
            x-model="query"
            @input.debounce.300ms="fetchSuggestions"
            @focus="showSuggestions = true"
            @keydown.enter.prevent="performSearch"
            @keydown.arrow-down.prevent="navigateSuggestion('down')"
            @keydown.arrow-up.prevent="navigateSuggestion('up')"
            @keydown.escape.prevent="showSuggestions = false"
            placeholder="{{ $placeholder }}"
            class="w-full rounded-lg border border-gray-300 bg-white py-2 pl-4 pr-12 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
        >
        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <button @click="performSearch" type="button" class="text-gray-400 hover:text-gray-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Suggestions Dropdown -->
    <div
        x-show="showSuggestions"
        x-cloak
        @click.away="showSuggestions = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute left-0 right-0 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
    >
        <div class="p-4 max-h-96 overflow-y-auto">
            <!-- Loading State -->
            <div x-show="loading" class="flex justify-center py-4">
                <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div x-show="!loading">
                <!-- Annonces -->
                <template x-if="suggestions.ads && suggestions.ads.length">
                    <div class="mb-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Annonces</h3>
                        <template x-for="ad in suggestions.ads" :key="ad.id">
                            <a :href="ad.url" class="block px-4 py-2 hover:bg-gray-50 rounded-md" :class="{ 'bg-gray-50': selectedIndex === getItemIndex(ad) }">
                                <span x-text="ad.title" class="text-sm text-gray-700"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Utilisateurs -->
                <template x-if="suggestions.users && suggestions.users.length">
                    <div class="mb-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Utilisateurs</h3>
                        <template x-for="user in suggestions.users" :key="user.id">
                            <a :href="user.url" class="block px-4 py-2 hover:bg-gray-50 rounded-md" :class="{ 'bg-gray-50': selectedIndex === getItemIndex(user) }">
                                <span x-text="user.name" class="text-sm text-gray-700"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Recherches similaires -->
                <template x-if="suggestions.similar && suggestions.similar.length">
                    <div class="mb-4">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Recherches similaires</h3>
                        <template x-for="(search, index) in suggestions.similar" :key="index">
                            <button @click="selectSimilarSearch(search)" type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-md" :class="{ 'bg-gray-50': selectedIndex === getSimilarIndex(index) }">
                                <span x-text="search" class="text-sm text-gray-700"></span>
                            </button>
                        </template>
                    </div>
                </template>

                <!-- Recherches récentes -->
                <template x-if="suggestions.recent && suggestions.recent.length">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Recherches récentes</h3>
                        <template x-for="(search, index) in suggestions.recent" :key="index">
                            <button @click="selectRecentSearch(search)" type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-50 rounded-md" :class="{ 'bg-gray-50': selectedIndex === getRecentIndex(index) }">
                                <span x-text="search" class="text-sm text-gray-700"></span>
                            </button>
                        </template>
                    </div>
                </template>

                <!-- No Results -->
                <template x-if="!hasSuggestions">
                    <div class="text-center py-4 text-sm text-gray-500">
                        Aucun résultat trouvé
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>

@push('scripts')
<script>
function searchBar() {
    return {
        query: '',
        suggestions: {},
        showSuggestions: false,
        loading: false,
        selectedIndex: -1,
        
        async fetchSuggestions() {
            if (this.query.length < 2) {
                this.suggestions = {};
                return;
            }

            this.loading = true;
            try {
                const response = await fetch(`/api/search/suggestions?q=${encodeURIComponent(this.query)}`);
                if (!response.ok) throw new Error('Network response was not ok');
                this.suggestions = await response.json();
                this.showSuggestions = true;
            } catch (error) {
                console.error('Error fetching suggestions:', error);
                this.suggestions = {};
            }
            this.loading = false;
        },

        async performSearch() {
            if (!this.query) return;

            try {
                // Save the search query
                await fetch('/api/search/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ q: this.query })
                });

                // Redirect to search results page
                window.location.href = `/search?q=${encodeURIComponent(this.query)}`;
            } catch (error) {
                console.error('Error saving search:', error);
                // Still redirect even if saving fails
                window.location.href = `/search?q=${encodeURIComponent(this.query)}`;
            }
        },

        selectSimilarSearch(search) {
            this.query = search;
            this.performSearch();
        },

        selectRecentSearch(search) {
            this.query = search;
            this.performSearch();
        },

        get hasSuggestions() {
            return (
                (this.suggestions.ads?.length > 0) ||
                (this.suggestions.users?.length > 0) ||
                (this.suggestions.similar?.length > 0) ||
                (this.suggestions.recent?.length > 0)
            );
        },

        getItemIndex(item) {
            let index = 0;
            if (this.suggestions.ads) {
                const adIndex = this.suggestions.ads.findIndex(ad => ad.id === item.id);
                if (adIndex !== -1) return index + adIndex;
                index += this.suggestions.ads.length;
            }
            if (this.suggestions.users) {
                const userIndex = this.suggestions.users.findIndex(user => user.id === item.id);
                if (userIndex !== -1) return index + userIndex;
                index += this.suggestions.users.length;
            }
            return -1;
        },

        getSimilarIndex(index) {
            let baseIndex = 0;
            if (this.suggestions.ads) baseIndex += this.suggestions.ads.length;
            if (this.suggestions.users) baseIndex += this.suggestions.users.length;
            return baseIndex + index;
        },

        getRecentIndex(index) {
            let baseIndex = 0;
            if (this.suggestions.ads) baseIndex += this.suggestions.ads.length;
            if (this.suggestions.users) baseIndex += this.suggestions.users.length;
            if (this.suggestions.similar) baseIndex += this.suggestions.similar.length;
            return baseIndex + index;
        },

        navigateSuggestion(direction) {
            const totalItems = this.getTotalItems();
            if (totalItems === 0) return;

            if (direction === 'down') {
                this.selectedIndex = this.selectedIndex < totalItems - 1 ? this.selectedIndex + 1 : 0;
            } else {
                this.selectedIndex = this.selectedIndex > 0 ? this.selectedIndex - 1 : totalItems - 1;
            }

            this.updateQueryFromSelection();
        },

        getTotalItems() {
            return (
                (this.suggestions.ads?.length || 0) +
                (this.suggestions.users?.length || 0) +
                (this.suggestions.similar?.length || 0) +
                (this.suggestions.recent?.length || 0)
            );
        },

        updateQueryFromSelection() {
            let item = this.getSelectedItem();
            if (item) {
                if (typeof item === 'string') {
                    this.query = item;
                } else if (item.title) {
                    this.query = item.title;
                } else if (item.name) {
                    this.query = item.name;
                }
            }
        },

        getSelectedItem() {
            if (this.selectedIndex === -1) return null;
            
            let index = this.selectedIndex;
            
            if (this.suggestions.ads) {
                if (index < this.suggestions.ads.length) return this.suggestions.ads[index];
                index -= this.suggestions.ads.length;
            }
            
            if (this.suggestions.users) {
                if (index < this.suggestions.users.length) return this.suggestions.users[index];
                index -= this.suggestions.users.length;
            }
            
            if (this.suggestions.similar) {
                if (index < this.suggestions.similar.length) return this.suggestions.similar[index];
                index -= this.suggestions.similar.length;
            }
            
            if (this.suggestions.recent) {
                if (index < this.suggestions.recent.length) return this.suggestions.recent[index];
            }
            
            return null;
        }
    }
}
</script>
@endpush 
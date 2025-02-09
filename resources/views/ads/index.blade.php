@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête avec titre et bouton de création -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Annonces') }}</h1>
            <a href="{{ route('ads.create.step1') }}" class="inline-flex items-center px-4 py-2 bg-[#35a79b] border border-transparent rounded-md font-semibold text-sm text-white hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Publier une annonce') }}
            </a>
        </div>

        <!-- Filtres simplifiés -->
        <div class="bg-white rounded-lg shadow-sm mb-6 p-4">
            <!-- Formulaire unique pour la recherche et les filtres -->
            <form id="search-form" method="GET" action="{{ route('ads.search') }}">
                <!-- Barre de recherche -->
                <div class="flex gap-4 mb-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}" 
                                   class="w-full rounded-md border-gray-300 pl-10 shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b] focus:ring-opacity-50"
                                   placeholder="{{ __('Que recherchez-vous ?') }}">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                            </div>

                <!-- Filtres -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Catégorie -->
                            <div>
                        <select name="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b] focus:ring-opacity-50">
                            <option value="">{{ __('Toutes les catégories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type -->
                            <div>
                        <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b] focus:ring-opacity-50">
                            <option value="">{{ __('Tous les types') }}</option>
                            <option value="goods" @selected(request('type') == 'goods')>{{ __('Biens') }}</option>
                                    <option value="services" @selected(request('type') == 'services')>{{ __('Services') }}</option>
                                </select>
                            </div>
                            </div>

                <!-- Bouton de recherche -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#35a79b] text-white rounded-md hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b]">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        {{ __('Rechercher') }}
                            </button>
                        </div>
            </form>
                    </div>

        <!-- Résultats de recherche si applicable -->
        @if(request()->hasAny(['q', 'category', 'type']))
                    <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900">
                    @if(request('q'))
                        {{ __('Résultats pour') }} "{{ request('q') }}"
                    @endif
                    @if(request('category'))
                        @php
                            $selectedCategory = $categories->firstWhere('id', request('category'));
                        @endphp
                        {{ request('q') ? ' ' . __('dans') . ' ' : __('Dans la catégorie') }} "{{ $selectedCategory->name }}"
                    @endif
                    @if(request('type'))
                        {{ request('q') || request('category') ? ' ' . __('et') . ' ' : __('Type') }} "{{ request('type') === 'goods' ? __('Biens') : __('Services') }}"
                            @endif
                    <span class="text-gray-500 text-sm">({{ $ads->total() }} {{ __('résultats') }})</span>
                </h2>
                    </div>
                @endif

        <!-- Grille d'annonces -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ads as $ad)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <!-- Image -->
                    <div class="relative aspect-w-16 aspect-h-9">
                        <a href="{{ route('ads.show', $ad) }}" class="block">
                            @if($ad->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                     alt="{{ $ad->title }}" 
                                     class="w-full h-48 object-cover rounded-t-lg">
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-t-lg">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Contenu -->
                            <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ route('ads.show', $ad) }}" class="hover:text-[#35a79b]">
                                            {{ $ad->title }}
                                        </a>
                                    </h3>

                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($ad->description, 100) }}</p>

                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $ad->created_at->diffForHumans() }}</span>
                            <span class="font-semibold text-[#35a79b]">{{ number_format($ad->price, 2) }} €</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $ad->type === 'goods' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ $ad->type === 'goods' ? __('Bien') : __('Service') }}
                                    </span>
                                @if($ad->category)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                        {{ $ad->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                <div class="col-span-3 py-12 text-center">
                            <div class="text-gray-500">
                        {{ __('Aucune annonce trouvée.') }}
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
        <div class="mt-8">
                    {{ $ads->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
// Empêcher la soumission du formulaire si tous les champs sont vides
document.getElementById('search-form').addEventListener('submit', function(e) {
    const searchInput = this.querySelector('input[name="q"]');
    const categorySelect = this.querySelector('select[name="category"]');
    const typeSelect = this.querySelector('select[name="type"]');
    
    if (!searchInput.value.trim() && !categorySelect.value && !typeSelect.value) {
        e.preventDefault();
        searchInput.focus();
    }
    });
</script>
@endpush
@endsection 
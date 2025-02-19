@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête avec titre et bouton de création -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-[#157e74] tracking-tight">{{ __('Troquez vos biens & services') }}</h1>
            <a href="{{ route('ads.create.step1') }}" class="inline-flex items-center px-6 py-3 bg-[#157e74] border border-transparent rounded-full font-medium text-white hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5 shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Publier une annonce') }}
            </a>
        </div>

        <!-- Filtres simplifiés -->
        <div class="bg-white rounded-2xl shadow-xl mb-8 p-6">
            <form id="search-form" method="GET" action="{{ route('ads.search') }}" class="space-y-4">
                <!-- Barre de recherche -->
                <div class="flex gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}" 
                                   class="w-full rounded-xl border-[#a3cca8] pl-10 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200"
                                   placeholder="Que recherchez-vous ?">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres avancés -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Catégorie -->
                    <div>
                        <select name="category" class="w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
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
                        <select name="type" class="w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                            <option value="">{{ __('Tous les types') }}</option>
                            <option value="goods" @selected(request('type') == 'goods')>{{ __('Biens') }}</option>
                            <option value="services" @selected(request('type') == 'services')>{{ __('Services') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Bouton de recherche -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5">
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
            <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
                <h2 class="text-lg font-medium text-[#157e74]">
                    @if(request('q'))
                        {{ __('Résultats pour') }} <span class="font-semibold">"{{ request('q') }}"</span>
                    @endif
                    @if(request('category'))
                        @php
                            $selectedCategory = $categories->firstWhere('id', request('category'));
                        @endphp
                        {{ request('q') ? ' ' . __('dans') . ' ' : __('Dans la catégorie') }} <span class="font-semibold">"{{ $selectedCategory->name }}"</span>
                    @endif
                    @if(request('type'))
                        {{ request('q') || request('category') ? ' ' . __('et') . ' ' : __('Type') }} <span class="font-semibold">"{{ request('type') === 'goods' ? __('Biens') : __('Services') }}"</span>
                    @endif
                    <span class="text-[#6dbaaf] text-sm ml-2">({{ $ads->total() }} {{ __('résultats') }})</span>
                </h2>
            </div>
        @endif

        <!-- Grille d'annonces -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($ads as $ad)
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                <!-- Image -->
                <div class="relative aspect-w-16 aspect-h-9">
                    <a href="{{ route('ads.show', $ad) }}" class="block">
                        @if($ad->images->isNotEmpty())
                            <img src="{{ $ad->images->first()->url }}" 
                                 alt="{{ $ad->title }}" 
                                 class="w-full h-48 object-cover rounded-t-2xl">
                        @else
                            <div class="w-full h-48 bg-gray-50 flex items-center justify-center rounded-t-2xl">
                                <svg class="w-12 h-12 text-[#a3cca8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </a>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        <a href="{{ route('ads.show', $ad) }}" class="hover:text-[#157e74] transition-colors duration-200">
                            {{ $ad->title }}
                        </a>
                    </h3>

                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($ad->description, 100) }}</p>

                    <div class="flex items-center justify-between text-sm mb-4">
                        <span class="text-[#6dbaaf]">{{ $ad->created_at->diffForHumans() }}</span>
                        <span class="font-semibold text-[#157e74]">{{ number_format($ad->price, 2) }} €</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $ad->type === 'goods' ? 'bg-[#e8f5e9] text-[#157e74]' : 'bg-[#f3e5f5] text-[#9c27b0]' }}">
                                {{ $ad->type === 'goods' ? __('Bien') : __('Service') }}
                            </span>
                            @if($ad->category)
                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-[#e8f5e9] text-[#157e74]">
                                    {{ $ad->category->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3">
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-[#a3cca8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-[#157e74]">{{ __('Aucune annonce trouvée') }}</h3>
                    <p class="mt-2 text-[#6dbaaf]">{{ __('Essayez de modifier vos critères de recherche ou publiez la première annonce !') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('ads.create.step1') }}" class="inline-flex items-center px-6 py-3 bg-[#157e74] text-white font-medium rounded-full hover:bg-[#279078] transform transition-all duration-200 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('Publier une annonce') }}
                        </a>
                    </div>
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
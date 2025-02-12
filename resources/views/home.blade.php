@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec titre et bouton de création -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-[#157e74]">Troquez vos biens & services</h1>
            <a href="{{ route('ads.create.step1') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Publier une annonce
            </a>
        </div>

        <!-- Filtres -->
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
                            <option value="">Toutes les catégories</option>
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
                            <option value="">Tous les types</option>
                            <option value="goods" @selected(request('type') == 'goods')>Biens</option>
                            <option value="services" @selected(request('type') == 'services')>Services</option>
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
                        Rechercher
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste d'annonces -->
        <div class="space-y-6">
            @forelse($latestAds as $ad)
                <x-ad-card :ad="$ad" />
            @empty
                <div class="text-center py-12">
                    <div class="text-[#6dbaaf]">
                        Aucune annonce disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Bouton voir plus -->
        <div class="mt-12 text-center">
            <a href="{{ route('ads.index') }}" 
               class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transition-all duration-200 transform hover:-translate-y-0.5">
                Voir toutes les annonces
                <svg class="ml-3 -mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </a>
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
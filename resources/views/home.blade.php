@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec titre et bouton de création -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-[#157e74]">Troquez vos biens & services</h1>
            <a href="{{ route('ads.create') }}" 
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
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200">
                    <div class="flex flex-col md:flex-row">
                        <!-- Image à gauche -->
                        <div class="md:w-1/3 relative">
                                @if($ad->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                         alt="{{ $ad->title }}" 
                                     class="w-full h-64 md:h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none">
                                @else
                                <div class="w-full h-64 md:h-full bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 flex items-center justify-center rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none">
                                        <span class="text-4xl text-[#157e74]">{{ substr($ad->title, 0, 1) }}</span>
                                    </div>
                                @endif
                                @if($ad->type)
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-[#157e74]/10 text-[#157e74]">
                                        {{ $ad->type === 'goods' ? 'Bien' : 'Service' }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                        <!-- Contenu à droite -->
                        <div class="flex-1 p-6">
                                <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-medium text-gray-900">
                                        <a href="{{ route('ads.show', $ad) }}" class="hover:text-[#157e74]">
                                            {{ $ad->title }}
                                        </a>
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $ad->status === 'active' ? 'Actif' : 'En attente' }}
                                    </span>
                                </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $ad->location }}
                                </div>

                            <p class="text-gray-500 mb-4 line-clamp-2">{{ $ad->description }}</p>

                            <!-- Section "À ÉCHANGER CONTRE" coulissante -->
                            <div class="border-t border-gray-100 pt-4">
                                <button type="button" 
                                        class="text-[#157e74] hover:text-[#279078] font-medium flex items-center focus:outline-none group w-full"
                                        onclick="toggleExchangeDetails(this)">
                                    <span>À ÉCHANGER CONTRE</span>
                                    <svg class="ml-2 h-5 w-5 transform transition-transform duration-200 group-data-[expanded=true]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="exchange-details hidden mt-4 pl-4 text-gray-600 border-l-2 border-[#157e74]/20">
                                    {{ $ad->exchange_with }}
                                </div>
                            </div>

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center text-sm text-[#6dbaaf]">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    {{ $ad->created_at->locale('fr')->diffForHumans() }}
                                </div>
                                @if($ad->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#157e74]/10 text-[#157e74]">
                                        {{ $ad->category->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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

// Fonction pour afficher/masquer les détails d'échange
function toggleExchangeDetails(button) {
    const details = button.nextElementSibling;
    const isExpanded = button.getAttribute('data-expanded') === 'true';
    
    if (isExpanded) {
        details.classList.add('hidden');
        button.setAttribute('data-expanded', 'false');
    } else {
        details.classList.remove('hidden');
        button.setAttribute('data-expanded', 'true');
    }
}
</script>
@endpush
@endsection
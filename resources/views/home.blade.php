@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#157e74] to-[#279078]">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-[#157e74] to-[#279078] mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl animate-fade-in-down">
                    FAISTROQUER
                </h1>
                <p class="mt-6 text-xl text-white/90 max-w-3xl animate-fade-in-up">
                    Une solution en ligne gratuite pour vous aider à échanger vos biens & services en toute confiance et simplicité.
                </p>
                <div class="mt-10 flex gap-4 animate-fade-in">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-[#157e74] bg-white hover:bg-[#a3cca8]/10 hover:text-white hover:border-white transition-all duration-200 transform hover:-translate-y-0.5">
                        Commencer maintenant
                    </a>
                    <a href="{{ route('how-it-works') }}" class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-full text-white hover:bg-white/10 transition-all duration-200">
                        Comment ça marche ?
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Articles -->
    @if(isset($articles) && $articles->count() > 0)
        <div class="bg-white py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-[#157e74] sm:text-4xl">
                        Actualités & Conseils
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                        Découvrez nos derniers articles sur le troc et l'échange
                    </p>
                </div>

                <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($articles as $article)
                        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200">
                            <!-- Image de l'article -->
                            <div class="relative w-full h-48 rounded-t-2xl overflow-hidden">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->title }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-200">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 flex items-center justify-center">
                                        <span class="text-4xl text-[#157e74]">{{ substr($article->title, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <!-- Badge catégorie -->
                                @if($article->category)
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-[#157e74]/10 text-[#157e74]">
                                            {{ $article->category }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu de l'article -->
                            <div class="p-6">
                                <!-- Date -->
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-[#157e74]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $article->formatted_date }}
                                </div>

                                <!-- Titre -->
                                <h3 class="text-xl font-bold text-[#157e74] group-hover:text-[#279078] transition-colors duration-200 mb-3">
                                    <a href="{{ route('articles.show', $article) }}" class="hover:underline">
                                        <span class="absolute inset-0"></span>
                                        {{ Str::limit($article->title, 60) }}
                                    </a>
                                </h3>

                                <!-- Extrait -->
                                <p class="text-gray-600 line-clamp-2 mb-4">
                                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                </p>

                                <!-- Auteur -->
                                @if($article->user)
                                    <div class="flex items-center mt-6 pt-4 border-t border-gray-100">
                                        <div class="flex-shrink-0">
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-[#157e74]">
                                                <span class="text-lg font-medium leading-none text-white">
                                                    {{ substr($article->user->name, 0, 1) }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $article->user->name }}</p>
                                            <p class="text-sm text-gray-500">Auteur</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bouton voir plus -->
                <div class="mt-12 text-center">
                    <a href="{{ route('articles.index') }}" 
                       class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transition-all duration-200 transform hover:-translate-y-0.5">
                        Voir tous nos articles
                        <svg class="ml-3 -mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Section des dernières annonces -->
    @if(isset($latestAds) && $latestAds->count() > 0)
        <div class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-[#157e74] sm:text-4xl">
                        Dernières annonces
                    </h2>
                    <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                        Découvrez les dernières opportunités d'échange
                    </p>
                </div>

                <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($latestAds as $ad)
                        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200">
                            <div class="relative w-full h-48 rounded-t-2xl overflow-hidden">
                                @if($ad->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-200">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 flex items-center justify-center">
                                        <span class="text-4xl text-[#157e74]">{{ substr($ad->title, 0, 1) }}</span>
                                    </div>
                                @endif
                                @if($ad->type)
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-[#157e74]/10 text-[#157e74]">
                                            {{ ucfirst($ad->type) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <a href="{{ route('ads.show', $ad) }}" class="hover:text-[#157e74]">
                                            {{ $ad->title }}
                                        </a>
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($ad->status) }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $ad->location }}
                                </div>
                                <div class="block">
                                    <p class="mt-2 text-gray-500 line-clamp-2">{{ Str::limit($ad->description, 100) }}</p>
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $ad->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

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
    @endif

    <!-- Categories Section -->
    @if(isset($categories))
        <div class="bg-white py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-3xl font-extrabold text-[#157e74]">Parcourir par catégorie</h2>
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center text-[#157e74] hover:text-[#279078] font-medium">
                        Voir toutes les catégories
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($categories->take(8) as $category)
                        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden">
                            <div class="relative w-full h-48 bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 group-hover:scale-105 transition-transform duration-200">
                                @if($category->icon)
                                    <img src="{{ $category->icon }}" alt="{{ $category->name }}" class="w-full h-full object-center object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <span class="text-4xl text-[#157e74] group-hover:scale-110 transition-transform duration-200">
                                            {{ substr($category->name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-[#157e74] group-hover:text-[#279078] transition-colors duration-200">
                                    <a href="{{ route('categories.show', $category) }}" class="hover:underline">
                                        <span class="absolute inset-0"></span>
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-[#6dbaaf]">{{ $category->ads_count ?? 0 }} annonces</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Call to Action Section -->
    <div class="bg-gradient-to-r from-[#157e74] to-[#279078]">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Prêt à commencer ?</span>
                <span class="block text-[#a3cca8]">Rejoignez notre communauté aujourd'hui.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-full shadow">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-[#157e74] bg-white hover:bg-[#a3cca8]/10 hover:text-white hover:border-white transition-all duration-200 transform hover:-translate-y-0.5">
                        Créer un compte
                    </a>
                </div>
                <div class="ml-4 inline-flex rounded-full shadow">
                    <a href="{{ route('ads.index') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-full text-white hover:bg-white/10 transition-all duration-200">
                        Parcourir les annonces
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fade-in {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 1s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 1s ease-out;
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }
</style>
@endpush
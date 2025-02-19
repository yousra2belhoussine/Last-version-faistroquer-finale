@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-[#35a79b] via-[#79d8b2] to-[#35a79b]/90 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-[#35a79b]/95 via-[#79d8b2]/90 to-[#35a79b]/85 mix-blend-multiply"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <div class="text-center">
            <img src="{{ asset('images/logo-white.png') }}" alt="FAISTROQUER Logo" class="h-24 w-auto mx-auto mb-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                FAISTROQUER
            </h1>
            <p class="mt-6 text-xl text-white/90 max-w-3xl mx-auto">
                Une solution en ligne gratuite pour vous aider à échanger vos biens & services en toute confiance et simplicité.
            </p>
            <div class="mt-10 flex justify-center gap-4">
                @auth
                    <a href="{{ route('ads.create.step1') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-[#35a79b] bg-white hover:bg-gray-50 transition-colors shadow-lg hover:shadow-xl">
                        Créer une annonce
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-[#35a79b] bg-white hover:bg-gray-50 transition-colors shadow-lg hover:shadow-xl">
                        Commencer maintenant
                    </a>
                @endauth
                <a href="{{ route('how-it-works') }}" 
                   class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-full text-white hover:bg-white/10 transition-colors">
                    Comment ça marche ?
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-white py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Parcourir par catégorie
            </h2>
            <a href="{{ route('categories.index') }}" class="text-[#35a79b] hover:text-[#2c8d83] font-medium flex items-center">
                Voir toutes les catégories
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" 
               class="group relative rounded-lg overflow-hidden bg-white shadow hover:shadow-lg transform hover:scale-[1.02] transition-all">
                <div class="aspect-w-4 aspect-h-3">
                    <img src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}" 
                         class="object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent group-hover:from-black/70 transition-all"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <h3 class="text-lg font-medium text-white">{{ $category->name }}</h3>
                    <p class="text-sm text-white/80">{{ $category->ads_count }} annonces</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Ads Section -->
<div class="bg-gray-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                Annonces récentes
            </h2>
            <a href="{{ route('ads.index') }}" class="text-[#35a79b] hover:text-[#2c8d83] font-medium flex items-center">
                Voir toutes les annonces
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <!-- Ads Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($recentAds->where('status', 'active') as $ad)
            <a href="{{ route('ads.show', $ad) }}" 
               class="group bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transform hover:scale-[1.02] transition-all">
                <div class="aspect-w-4 aspect-h-3">
                    @if($ad->images->count() > 0)
                        <img src="{{ $ad->images->first()->url }}" 
                             alt="{{ $ad->title }}" 
                             class="object-cover w-full h-48 rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-t-lg">
                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 group-hover:text-[#35a79b] transition-colors">
                        {{ $ad->title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ Str::limit($ad->description, 100) }}
                    </p>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $ad->user->profile_photo_url }}" 
                                 alt="{{ $ad->user->name }}" 
                                 class="h-8 w-8 rounded-full">
                            <span class="ml-2 text-sm text-gray-600">{{ $ad->user->name }}</span>
                        </div>
                        <span class="text-sm text-gray-500">
                            {{ $ad->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush 
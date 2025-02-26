@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 bg-gradient-to-br from-[#edf76] to-[#e5f5f3]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Mes annonces') }}</h1>
                <p class="mt-1 text-sm text-gray-600">{{ __('Gérez vos annonces et suivez leur statut') }}</p>
            </div>
            <a href="{{ route('ads.create.step1') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Créer une annonce') }}
            </a>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-[#35a79b]/20">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           placeholder="Rechercher dans vos annonces..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#157e74] focus:border-[#157e74]">
                </div>
                <div class="flex gap-4">
                    
                    <select class="px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#157e74] focus:border-[#157e74]">
                        <option value="">Trier par</option>
                        <option value="newest">Plus récent</option>
                        <option value="oldest">Plus ancien</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Ads Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($ads as $ad)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200 border border-[#35a79b]/20">
                    <!-- Image Container -->
                    <div class="aspect-w-16 aspect-h-9 relative group">
                        @if($ad->images->isNotEmpty())
                            <img src="{{ $ad->images->first()->url }}" 
                                 alt="{{ $ad->title }}" 
                                 class="w-full h-48 object-cover"
                                 onerror="this.src='{{ asset('images/default-ad-image.png') }}'">
                        @else
                            <img src="{{ asset('images/default-ad-image.png') }}" 
                                 alt="{{ $ad->title }}" 
                                 class="w-full h-48 object-cover">
                        @endif
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium 
                                {{ $ad->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($ad->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($ad->status) }}
                            </span>
                        </div>
                        <!-- Hover Actions -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-4">
                            <a href="{{ route('ads.edit', $ad) }}" 
                               class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('ads.destroy', $ad) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors"
                                        onclick="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer cette annonce ?') }}')">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 truncate">{{ $ad->title }}</h3>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $ad->description }}</p>
                        
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-[#157e74]">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $ad->created_at->diffForHumans() }}
                            </span>
                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-[#35a79b]/20">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('Aucune annonce') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Commencez par créer votre première annonce.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('ads.create.step1') }}" 
                               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Créer une annonce') }}
                            </a>
                        </div>
                    </div>
                                    </div>
            @endforelse
                                    </div>

        <!-- Pagination -->
        @if($ads->hasPages())
                    <div class="mt-6">
                        {{ $ads->links() }}
                    </div>
                @endif
    </div>
</div>
@endsection 
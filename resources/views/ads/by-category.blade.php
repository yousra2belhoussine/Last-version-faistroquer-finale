@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Category Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
            <p class="text-gray-600">{{ $ads->total() }} annonces trouvées</p>
        </div>

        <!-- Ads Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($ads as $ad)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 group">
                    <a href="{{ route('ads.show', $ad) }}" class="block">
                        <div class="aspect-w-16 aspect-h-9 rounded-t-lg overflow-hidden">
                            @if($ad->images->isNotEmpty())
                                <img src="{{ Storage::url($ad->images->first()->path) }}" 
                                     alt="{{ $ad->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $ad->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $ad->description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">
                                            {{ substr($ad->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $ad->user->name }}</span>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $ad->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune annonce</h3>
                    <p class="mt-1 text-sm text-gray-500">Aucune annonce n'a été trouvée dans cette catégorie.</p>
                    <div class="mt-6">
                        <a href="{{ route('ads.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Créer une annonce
                        </a>
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
@endsection 
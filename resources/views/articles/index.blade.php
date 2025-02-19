@extends('layouts.app')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Articles</h1>
            <a href="{{ route('articles.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#1a9587] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Créer un article
            </a>
        </div>

        <!-- Filtres -->
        <div class="mb-6 flex flex-wrap gap-4">
            <a href="{{ request()->url() }}" 
               class="px-4 py-2 rounded-full text-sm {{ !request('status') ? 'bg-[#157e74] text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Tous
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-full text-sm {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Approuvés
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-full text-sm {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                En attente
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-full text-sm {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                Rejetés
            </a>
        </div>

        @if($articles->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun article</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouvel article.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        @if($article->images->isNotEmpty())
                            <div class="relative h-48 rounded-t-lg overflow-hidden">
                                <img src="{{ Storage::url($article->images->first()->path) }}" 
                                     alt="Image de l'article" 
                                     class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($article->status === 'approved') bg-green-100 text-green-800
                                        @elseif($article->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        @if($article->status === 'approved')
                                            Actif
                                        @elseif($article->status === 'rejected')
                                            Rejeté
                                        @else
                                            En attente
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-[#157e74] font-medium">
                                    {{ $article->category->name }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $article->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <a href="{{ route('articles.show', $article) }}" class="hover:text-[#157e74]">
                                    {{ $article->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $article->description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block h-8 w-8 rounded-full bg-[#157e74] text-white text-center leading-8">
                                            {{ substr($article->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $article->user->name }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('articles.show', $article) }}" 
                                   class="text-sm font-medium text-[#157e74] hover:text-[#1a9587]">
                                    Lire plus →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection 
@extends('layouts.app')

@section('content')
<div class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Mes Articles</h1>
                <p class="mt-2 text-sm text-gray-600">Gérez vos articles et partagez votre expertise</p>
            </div>
            <a href="{{ route('articles.create') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#1a9587] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transition-all duration-200">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Créer un article
            </a>
        </div>

        @if($articles->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="w-16 h-16 bg-[#157e74]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#157e74]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun article publié</h3>
                <p class="text-gray-500 mb-4">Commencez à partager vos connaissances en créant votre premier article.</p>
                <a href="{{ route('articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#1a9587] transition-all duration-200">
                    Créer mon premier article
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden group">
                        @if($article->images->isNotEmpty())
                            <div class="relative h-48">
                                <img src="{{ Storage::url($article->images->first()->path) }}" 
                                     alt="{{ $article->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm font-medium text-[#157e74] bg-[#157e74]/10 px-3 py-1 rounded-full">
                                    {{ $article->category->name }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $article->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-[#157e74] transition-colors duration-200">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $article->description }}
                            </p>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('articles.edit', $article) }}" 
                                       class="text-sm font-medium text-[#157e74] hover:text-[#1a9587] transition-colors duration-200 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Modifier
                                    </a>
                                    <form action="{{ route('articles.destroy', $article) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                                <a href="{{ route('articles.show', $article) }}" 
                                   class="text-sm font-medium text-[#157e74] hover:text-[#1a9587] transition-colors duration-200">
                                    Voir l'article →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection 
@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-[#157e74] sm:text-5xl">Articles</h1>
            <p class="mt-4 text-lg text-[#6dbaaf]">Découvrez nos derniers articles et conseils</p>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($articles as $article)
                <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden">
                    <div class="relative w-full h-48 bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 group-hover:scale-105 transition-transform duration-200">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-center object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-4xl text-[#157e74] group-hover:scale-110 transition-transform duration-200">
                                    {{ substr($article->title, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        @if(!$article->is_published)
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Brouillon</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-[#6dbaaf] mb-2">
                            @if($article->published_at)
                                <span>{{ $article->published_at->format('d M Y') }}</span>
                                @if($article->category)
                                    <span class="mx-2">•</span>
                                @endif
                            @endif
                            @if($article->category)
                                <span>{{ $article->category }}</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-[#157e74] group-hover:text-[#279078] transition-colors duration-200">
                            <a href="{{ route('articles.show', $article) }}" class="hover:underline">
                                <span class="absolute inset-0"></span>
                                {{ $article->title }}
                            </a>
                        </h3>
                        <p class="mt-2 text-sm text-[#6dbaaf] line-clamp-2">{{ $article->excerpt }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $articles->links() }}
        </div>

        @auth
            <div class="mt-12 text-center">
                <a href="{{ route('articles.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer un article
                </a>
            </div>
        @endauth
    </div>
</div>
@endsection 
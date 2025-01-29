@extends('layouts.app')

@section('content')
<article class="bg-white">
    <div class="max-w-4xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        @if($article->featured_image)
            <div class="aspect-w-16 aspect-h-9 mb-8 rounded-2xl overflow-hidden">
                <img src="{{ asset('storage/' . $article->featured_image) }}" 
                     alt="{{ $article->title }}" 
                     class="w-full h-full object-center object-cover">
            </div>
        @endif

        <div class="text-center mb-12">
            <div class="flex items-center justify-center text-sm text-[#6dbaaf] mb-4">
                @if(isset($article->formatted_date))
                    <span>{{ $article->formatted_date }}</span>
                    @if($article->category)
                        <span class="mx-2">•</span>
                    @endif
                @endif
                @if($article->category)
                    <span>{{ $article->category }}</span>
                @endif
                @if(!$article->is_published)
                    <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Brouillon</span>
                @endif
            </div>
            <h1 class="text-4xl font-extrabold tracking-tight text-[#157e74] sm:text-5xl">
                {{ $article->title }}
            </h1>
            @if($article->excerpt)
                <p class="mt-4 text-xl text-[#6dbaaf]">{{ $article->excerpt }}</p>
            @endif
        </div>

        <div class="prose prose-lg max-w-none text-[#2d3748]">
            {!! $article->content !!}
        </div>

        @auth
            @if(auth()->id() === $article->user_id)
                <div class="mt-12 flex justify-center space-x-4">
                    <a href="{{ route('articles.edit', $article) }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier l'article
                    </a>

                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border-2 border-[#157e74] text-base font-medium rounded-full text-[#157e74] hover:bg-[#157e74] hover:text-white transition-all duration-200"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer l'article
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</article>
@endsection 
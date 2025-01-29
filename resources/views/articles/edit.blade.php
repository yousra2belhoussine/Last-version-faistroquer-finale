@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-[#157e74] sm:text-5xl">Modifier l'article</h1>
            <p class="mt-4 text-lg text-[#6dbaaf]">Mettez à jour votre article</p>
        </div>

        <div class="mt-12">
            <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-[#157e74]">Titre</label>
                    <div class="mt-1">
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" 
                               class="shadow-sm focus:ring-[#157e74] focus:border-[#157e74] block w-full sm:text-sm border-gray-300 rounded-md"
                               required>
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="excerpt" class="block text-sm font-medium text-[#157e74]">Extrait</label>
                    <div class="mt-1">
                        <textarea name="excerpt" id="excerpt" rows="3" 
                                  class="shadow-sm focus:ring-[#157e74] focus:border-[#157e74] block w-full sm:text-sm border-gray-300 rounded-md">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>
                    @error('excerpt')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-[#157e74]">Contenu</label>
                    <div class="mt-1">
                        <textarea name="content" id="content" rows="10" 
                                  class="shadow-sm focus:ring-[#157e74] focus:border-[#157e74] block w-full sm:text-sm border-gray-300 rounded-md"
                                  required>{{ old('content', $article->content) }}</textarea>
                    </div>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-[#157e74]">Catégorie</label>
                    <div class="mt-1">
                        <select name="category" id="category" 
                                class="shadow-sm focus:ring-[#157e74] focus:border-[#157e74] block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="Conseils" {{ old('category', $article->category) == 'Conseils' ? 'selected' : '' }}>Conseils</option>
                            <option value="Tutoriels" {{ old('category', $article->category) == 'Tutoriels' ? 'selected' : '' }}>Tutoriels</option>
                            <option value="Actualités" {{ old('category', $article->category) == 'Actualités' ? 'selected' : '' }}>Actualités</option>
                        </select>
                    </div>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="featured_image" class="block text-sm font-medium text-[#157e74]">Image de couverture</label>
                    @if($article->featured_image)
                        <div class="mt-2 mb-4">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                 alt="Image actuelle" 
                                 class="h-32 w-auto rounded-lg">
                        </div>
                    @endif
                    <div class="mt-1">
                        <input type="file" name="featured_image" id="featured_image" 
                               class="shadow-sm focus:ring-[#157e74] focus:border-[#157e74] block w-full sm:text-sm border-gray-300"
                               accept="image/*">
                    </div>
                    @error('featured_image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_published" id="is_published" value="1" 
                           class="h-4 w-4 text-[#157e74] focus:ring-[#157e74] border-gray-300 rounded"
                           {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 block text-sm text-[#157e74]">
                        Publier immédiatement
                    </label>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('articles.show', $article) }}" 
                       class="inline-flex items-center px-6 py-3 border-2 border-[#157e74] text-base font-medium rounded-full text-[#157e74] hover:bg-[#157e74] hover:text-white transition-all duration-200">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transition-all duration-200">
                        Mettre à jour l'article
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
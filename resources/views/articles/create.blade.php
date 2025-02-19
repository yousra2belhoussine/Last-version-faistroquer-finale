@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Créer un nouvel article</h2>

                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'article</label>
                        <input type="text" name="title" id="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50"></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category_id" id="category_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Images -->
                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                        <div class="mt-1 flex flex-col items-center">
                            <div class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative cursor-pointer hover:border-[#157e74]">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-[#157e74] hover:text-[#1a9587] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#157e74]">
                                            <span>Télécharger des images</span>
                                            <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" onchange="handleImagePreview(this)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 10MB</p>
                                </div>
                            </div>
                            
                            <!-- Prévisualisation des images -->
                            <div id="imagePreviewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            </div>
                        </div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('articles.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#1a9587] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                            Créer l'article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleImagePreview(input) {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = ''; // Nettoyer les prévisualisations existantes
    
    if (input.files) {
        [...input.files].forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-32 object-cover rounded-lg';
                    
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity';
                    removeButton.innerHTML = '×';
                    removeButton.onclick = function() {
                        div.remove();
                    };
                    
                    div.appendChild(img);
                    div.appendChild(removeButton);
                    container.appendChild(div);
                };
                
                reader.readAsDataURL(file);
            }
        });
    }
}
</script>
@endpush
@endsection 
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier l\'annonce') }}
            </h2>
            <a href="{{ route('admin.ads.show', $ad->id) }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
                Retour aux détails
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre de l'annonce</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $ad->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="5"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">{{ old('description', $ad->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prix -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Prix (€)</label>
                            <input type="number" 
                                   name="price" 
                                   id="price" 
                                   step="0.01"
                                   value="{{ old('price', $ad->price) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catégorie -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="category_id" 
                                    id="category_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $ad->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- État -->
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700">État</label>
                            <select name="condition" 
                                    id="condition" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                                <option value="new" {{ old('condition', $ad->condition) == 'new' ? 'selected' : '' }}>Neuf</option>
                                <option value="like_new" {{ old('condition', $ad->condition) == 'like_new' ? 'selected' : '' }}>Comme neuf</option>
                                <option value="good" {{ old('condition', $ad->condition) == 'good' ? 'selected' : '' }}>Bon état</option>
                                <option value="fair" {{ old('condition', $ad->condition) == 'fair' ? 'selected' : '' }}>État moyen</option>
                                <option value="poor" {{ old('condition', $ad->condition) == 'poor' ? 'selected' : '' }}>À rénover</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Images actuelles -->
                        @if($ad->images && $ad->images->count() > 0)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Images actuelles</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($ad->images as $image)
                                <div class="relative group">
                                    <img src="{{ $image->url }}" 
                                         alt="Image de l'annonce" 
                                         class="w-full h-32 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-150 rounded-lg flex items-center justify-center">
                                        <button type="button" 
                                                onclick="deleteImage({{ $image->id }})"
                                                class="hidden group-hover:block text-white bg-red-600 px-3 py-1 rounded-md text-sm">
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Nouvelles images -->
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700">Ajouter des images</label>
                            <input type="file" 
                                   name="images[]" 
                                   id="images" 
                                   multiple 
                                   accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-[#157e74] file:text-white hover:file:bg-[#279078]">
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Vous pouvez sélectionner plusieurs images. Formats acceptés : JPG, PNG, GIF</p>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('admin.ads.show', $ad->id) }}" 
                               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteImage(imageId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                fetch(`/admin/ads/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          window.location.reload();
                      }
                  });
            }
        }
    </script>
    @endpush
</x-app-layout> 
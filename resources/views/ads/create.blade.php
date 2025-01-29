@extends('layouts.app')

@section('content')
<div class="py-6 bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl">
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-extrabold text-[#35a79b]">{{ __('Créer une nouvelle annonce') }}</h1>
                    <p class="text-[#79d8b2] mt-1">{{ __('Remplissez les détails ci-dessous pour créer votre annonce.') }}</p>
                </div>

                <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if(session('error'))
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Titre') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 block w-full rounded-lg @error('title') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20"
                            value="{{ old('title') }}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Description') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <textarea name="description" id="description" rows="4" required
                            class="mt-1 block w-full rounded-lg @error('description') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prix -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Prix') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <div class="mt-1 relative rounded-lg shadow-sm">
                            <input type="number" name="price" id="price" required min="0" step="0.01"
                                class="block w-full rounded-lg @error('price') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20 pl-3 pr-12"
                                value="{{ old('price') }}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">€</span>
                            </div>
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Catégorie') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                            class="mt-1 block w-full rounded-lg @error('category_id') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">
                            <option value="">{{ __('Sélectionnez une catégorie') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Région -->
                    <div class="mb-4">
                        <label for="region_id" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Région') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <select name="region_id" id="region_id" required
                            class="mt-1 block w-full rounded-lg @error('region_id') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">
                            <option value="">{{ __('Sélectionnez une région') }}</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Type') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full rounded-lg @error('type') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">
                            <option value="">{{ __('Sélectionnez un type') }}</option>
                            <option value="goods" {{ old('type') == 'good' ? 'selected' : '' }}>{{ __('Bien') }}</option>
                            <option value="services" {{ old('type') == 'service' ? 'selected' : '' }}>{{ __('Service') }}</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Département -->
                    <div>
                        <label for="department" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Département') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <input type="text" name="department" id="department" required
                            class="mt-1 block w-full rounded-lg @error('department') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20"
                            value="{{ old('department') }}">
                        @error('department')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ville -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Ville') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <input type="text" name="city" id="city" required
                            class="mt-1 block w-full rounded-lg @error('city') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20"
                            value="{{ old('city') }}">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Code postal -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Code postal') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <input type="text" name="postal_code" id="postal_code" required
                            class="mt-1 block w-full rounded-lg @error('postal_code') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20"
                            value="{{ old('postal_code') }}">
                        @error('postal_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- État -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('État') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <select name="condition" id="condition" required
                            class="mt-1 block w-full rounded-lg @error('condition') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">
                            <option value="">{{ __('Sélectionnez l\'état') }}</option>
                            <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>{{ __('Neuf') }}</option>
                            <option value="like_new" {{ old('condition') == 'like_new' ? 'selected' : '' }}>{{ __('Comme neuf') }}</option>
                            <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>{{ __('Bon état') }}</option>
                            <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>{{ __('État correct') }}</option>
                        </select>
                        @error('condition')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Échange souhaité -->
                    <div>
                        <label for="exchange_with" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Que souhaitez-vous en échange ?') }} <span class="text-[#f45157]">*</span>
                        </label>
                        <textarea name="exchange_with" id="exchange_with" rows="3" required
                            class="mt-1 block w-full rounded-lg @error('exchange_with') border-red-500 @else border-[#79d8b2] @enderror shadow-sm focus:border-[#35a79b] focus:ring focus:ring-[#35a79b]/20">{{ old('exchange_with') }}</textarea>
                        @error('exchange_with')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Échange en ligne -->
                    <div class="flex items-center">
                        <input type="checkbox" name="online_exchange" id="online_exchange" value="1"
                            class="rounded border-[#79d8b2] text-[#35a79b] focus:ring-[#35a79b]/20"
                            {{ old('online_exchange') ? 'checked' : '' }}>
                        <label for="online_exchange" class="ml-2 text-sm text-gray-600">
                            {{ __('Accepte les échanges en ligne') }}
                        </label>
                    </div>

                    <!-- Images -->
                    <div>
                        <label for="images" class="block text-sm font-medium text-[#35a79b]">
                            {{ __('Images') }}
                        </label>
                        <div id="dropzone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-[#35a79b] transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="images" class="relative cursor-pointer rounded-md font-medium text-[#35a79b] hover:text-[#35a79b]/90">
                                        <span>{{ __('Déposez vos images ici') }}</span>
                                        <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/jpeg,image/png,image/jpg,image/gif">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG ou GIF jusqu'à 2MB</p>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                            <!-- Les prévisualisations seront ajoutées ici -->
                        </div>
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-4 py-2 border border-[#79d8b2] rounded-lg text-sm font-medium text-[#35a79b] bg-white hover:bg-[#35a79b]/10">
                            {{ __('Annuler') }}
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-[#35a79b] hover:bg-[#35a79b]/90">
                            {{ __('Publier l\'annonce') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropzone = document.getElementById('dropzone');
    const input = document.querySelector('input[name="images[]"]');
    const preview = document.getElementById('image-preview');

    if (!dropzone || !input || !preview) {
        console.error('Un ou plusieurs éléments requis sont manquants');
        return;
    }

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) {
                console.warn('Le fichier doit être une image:', file.name);
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                console.warn('Le fichier est trop volumineux:', file.name);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                    <button type="button" class="remove-image absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;

                div.querySelector('.remove-image').onclick = function() {
                    div.remove();
                    updateInputFiles();
                };

                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        const currentImages = preview.querySelectorAll('img');
        Array.from(input.files).forEach((file, index) => {
            if (index < currentImages.length) {
                dataTransfer.items.add(file);
            }
        });
        input.files = dataTransfer.files;
    }

    input.onchange = function() {
        handleFiles(this.files);
    };

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('border-[#35a79b]', 'bg-[#35a79b]/5');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('border-[#35a79b]', 'bg-[#35a79b]/5');
        });
    });

    dropzone.addEventListener('drop', e => {
        handleFiles(e.dataTransfer.files);
    });
});
</script>
@endpush
@endsection 
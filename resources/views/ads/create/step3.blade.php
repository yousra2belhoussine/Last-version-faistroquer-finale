@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#157e74]">{{ __('Déposer une annonce') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('Étape 3 sur 4 : Prix et photos') }}</p>
        </div>

        <!-- Indicateur de progression -->
        <div class="relative mb-8">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-[#a3cca8]/20">
                <div class="w-3/4 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#157e74]"></div>
            </div>
            <div class="flex justify-between text-xs text-[#157e74]">
                <div class="text-gray-400">Étape 1</div>
                <div class="text-gray-400">Étape 2</div>
                <div class="font-semibold">Étape 3</div>
                <div class="text-gray-400">Étape 4</div>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('ads.create.step3.store') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6">
            @csrf

            <!-- Prix -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="price">
                    {{ __('Prix estimé') }}
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" name="price" id="price" min="0" step="0.01"
                        class="block w-full pr-12 rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('price') border-red-300 @enderror"
                        value="{{ old('price') }}"
                        placeholder="0.00">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">€</span>
                    </div>
                </div>
                @error('price')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    {{ __('Cette valeur est indicative et servira de base pour les échanges.') }}
                </p>
            </div>

            <!-- Images -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Photos') }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer rounded-md font-medium text-[#157e74] hover:text-[#157e74]/90 focus-within:outline-none">
                                <span>{{ __('Télécharger des fichiers') }}</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">{{ __('ou glisser-déposer') }}</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ __('PNG, JPG, GIF jusqu\'à 2MB') }}
                        </p>
                    </div>
                </div>
                <div id="image-preview" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                    <!-- Les prévisualisations seront ajoutées ici -->
                </div>
                @error('images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between space-x-4">
                <a href="{{ route('ads.create.step2') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    {{ __('Retour') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#157e74] hover:bg-[#157e74]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    {{ __('Continuer') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('div.border-dashed');
    const input = document.querySelector('input[type="file"]');
    const preview = document.getElementById('image-preview');

    // Gestion du drag & drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-[#157e74]', 'bg-[#157e74]/5');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-[#157e74]', 'bg-[#157e74]/5');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    input.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        preview.innerHTML = '';
        [...files].forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="" class="object-cover">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/10"></div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush 
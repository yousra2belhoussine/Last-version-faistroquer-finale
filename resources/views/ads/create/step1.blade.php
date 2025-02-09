@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#157e74]">{{ __('Déposer une annonce') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('Étape 1 sur 4 : Type et catégorie') }}</p>
        </div>

        <!-- Indicateur de progression -->
        <div class="relative mb-8">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-[#a3cca8]/20">
                <div class="w-1/4 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#157e74]"></div>
            </div>
            <div class="flex justify-between text-xs text-[#157e74]">
                <div class="font-semibold">Étape 1</div>
                <div class="text-gray-400">Étape 2</div>
                <div class="text-gray-400">Étape 3</div>
                <div class="text-gray-400">Étape 4</div>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('ads.create.step1.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf

            <!-- Type de troc -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Type de troc') }} <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Type Bien -->
                    <div class="relative">
                        <input type="radio" id="type_goods" name="type" value="goods" class="peer sr-only" {{ old('type') === 'goods' ? 'checked' : '' }}>
                        <label for="type_goods" class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors duration-200 peer-checked:border-[#157e74] peer-checked:bg-[#a3cca8]/10 hover:border-[#157e74] @error('type') border-red-300 @else border-gray-200 @enderror">
                            <svg class="h-6 w-6 text-[#157e74]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">{{ __('Bien') }}</span>
                                <span class="text-xs text-gray-500 block">{{ __('Objets, vêtements, etc.') }}</span>
                            </span>
                        </label>
                    </div>

                    <!-- Type Service -->
                    <div class="relative">
                        <input type="radio" id="type_services" name="type" value="services" class="peer sr-only" {{ old('type') === 'services' ? 'checked' : '' }}>
                        <label for="type_services" class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-colors duration-200 peer-checked:border-[#157e74] peer-checked:bg-[#a3cca8]/10 hover:border-[#157e74] @error('type') border-red-300 @else border-gray-200 @enderror">
                            <svg class="h-6 w-6 text-[#157e74]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">{{ __('Service') }}</span>
                                <span class="text-xs text-gray-500 block">{{ __('Compétences, aide, etc.') }}</span>
                            </span>
                        </label>
                    </div>
                </div>
                @error('type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catégorie -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="category_id">
                    {{ __('Catégorie') }} <span class="text-red-500">*</span>
                </label>
                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('category_id') border-red-300 @enderror">
                    <option value="">{{ __('Sélectionnez une catégorie') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    {{ __('Annuler') }}
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
    const typeLabels = document.querySelectorAll('label[for="type"]');
    typeLabels.forEach(label => {
        label.addEventListener('click', function() {
            typeLabels.forEach(l => l.classList.remove('border-[#157e74]', 'bg-[#a3cca8]/10'));
            this.classList.add('border-[#157e74]', 'bg-[#a3cca8]/10');
        });
    });
});
</script>
@endpush 
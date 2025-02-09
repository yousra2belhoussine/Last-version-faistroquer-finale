@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#157e74]">{{ __('Déposer une annonce') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('Étape 4 sur 4 : Localisation') }}</p>
        </div>

        <!-- Indicateur de progression -->
        <div class="relative mb-8">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-[#a3cca8]/20">
                <div class="w-full shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#157e74]"></div>
            </div>
            <div class="flex justify-between text-xs text-[#157e74]">
                <div class="text-gray-400">Étape 1</div>
                <div class="text-gray-400">Étape 2</div>
                <div class="text-gray-400">Étape 3</div>
                <div class="font-semibold">Étape 4</div>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('ads.create.step4.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf

            <!-- Région -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="region_id">
                    {{ __('Région') }}
                </label>
                <select name="region_id" id="region_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('region_id') border-red-300 @enderror">
                    <option value="">{{ __('Sélectionnez une région') }}</option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
                @error('region_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Département -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="department">
                    {{ __('Département') }}
                </label>
                <input type="text" name="department" id="department"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('department') border-red-300 @enderror"
                    value="{{ old('department') }}"
                    placeholder="Ex: Loire-Atlantique">
                @error('department')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ville -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="city">
                    {{ __('Ville') }}
                </label>
                <input type="text" name="city" id="city"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('city') border-red-300 @enderror"
                    value="{{ old('city') }}"
                    placeholder="Ex: Nantes">
                @error('city')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code postal -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="postal_code">
                    {{ __('Code postal') }}
                </label>
                <input type="text" name="postal_code" id="postal_code"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('postal_code') border-red-300 @enderror"
                    value="{{ old('postal_code') }}"
                    placeholder="Ex: 44000">
                @error('postal_code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between space-x-4">
                <a href="{{ route('ads.create.step3') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    {{ __('Retour') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#157e74] hover:bg-[#157e74]/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    {{ __('Publier l\'annonce') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#157e74]">{{ __('Déposer une annonce') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('Étape 2 sur 4 : Description de votre annonce') }}</p>
        </div>

        <!-- Indicateur de progression -->
        <div class="relative mb-8">
            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-[#a3cca8]/20">
                <div class="w-2/4 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-[#157e74]"></div>
            </div>
            <div class="flex justify-between text-xs text-[#157e74]">
                <div class="text-gray-400">Étape 1</div>
                <div class="font-semibold">Étape 2</div>
                <div class="text-gray-400">Étape 3</div>
                <div class="text-gray-400">Étape 4</div>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('ads.create.step2.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf

            <!-- Titre -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="title">
                    {{ __('Titre de l\'annonce') }}
                </label>
                <input type="text" name="title" id="title" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('title') border-red-300 @enderror"
                    value="{{ old('title') }}"
                    placeholder="Ex: Vélo VTT en bon état">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="description">
                    {{ __('Description détaillée') }}
                </label>
                <textarea name="description" id="description" rows="6"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('description') border-red-300 @enderror"
                    placeholder="Décrivez votre bien ou service en détail...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ce que vous souhaitez en échange -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="exchange_with">
                    {{ __('Ce que vous souhaitez en échange') }}
                </label>
                <textarea name="exchange_with" id="exchange_with" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 @error('exchange_with') border-red-300 @enderror"
                    placeholder="Décrivez ce que vous recherchez en échange...">{{ old('exchange_with') }}</textarea>
                @error('exchange_with')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between space-x-4">
                <a href="{{ route('ads.create.step1') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
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
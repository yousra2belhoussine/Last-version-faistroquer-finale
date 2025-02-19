<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Détails de l\'annonce') }}
            </h2>
            <a href="{{ route('admin.ads.index') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Informations principales -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations principales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Titre</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Prix</p>
                                <p class="mt-1 text-sm text-gray-900">{{ number_format($ad->price, 2, ',', ' ') }} €</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Catégorie</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->category->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">État</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->condition }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date de création</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Dernière modification</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $ad->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $ad->description }}</p>
                        </div>
                    </div>

                    <!-- Images -->
                    @if($ad->images && $ad->images->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Images</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($ad->images as $image)
                            <div class="relative aspect-w-1 aspect-h-1 group">
                                <img src="{{ $image->url }}" 
                                     alt="Image de l'annonce" 
                                     class="w-full h-48 object-cover rounded-lg shadow-sm hover:opacity-75 transition-opacity duration-150">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity duration-150 rounded-lg flex items-center justify-center">
                                    <a href="{{ $image->url }}" 
                                       target="_blank" 
                                       class="hidden group-hover:block text-white bg-black bg-opacity-50 px-4 py-2 rounded-md">
                                        Voir l'image
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Images</h3>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-sm text-gray-500">Aucune image disponible pour cette annonce</p>
                        </div>
                    </div>
                    @endif

                    <!-- Informations sur l'utilisateur -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations sur le vendeur</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-[#157e74] flex items-center justify-center">
                                        <span class="text-white font-medium text-sm">
                                            {{ strtoupper(substr($ad->user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $ad->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $ad->user->email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.ads.edit', $ad->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Modifier
                            </a>
                        </div>

                        <form action="{{ route('admin.ads.destroy', $ad->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
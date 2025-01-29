@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Améliorer votre crédibilité</h1>
        <p class="text-gray-500">Découvrez comment augmenter votre score de crédibilité et gagner la confiance de la communauté</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Conseils et actions -->
        <div class="md:col-span-2">
            <!-- Conseils personnalisés -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Conseils personnalisés</h2>
                <div class="space-y-6">
                    @foreach($credibilityTips as $tip)
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-900">{{ $tip['title'] }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $tip['description'] }}</p>
                                @if(isset($tip['action']))
                                    <a href="{{ $tip['action']['url'] }}" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                        {{ $tip['action']['label'] }}
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions recommandées -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Actions recommandées</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center mb-3">
                            <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-green-900">Compléter votre profil</h3>
                        </div>
                        <p class="text-sm text-green-700">Ajoutez une photo et complétez vos informations personnelles pour gagner en crédibilité.</p>
                        <a href="{{ route('profile.edit') }}" class="mt-3 inline-flex items-center text-sm text-green-600 hover:text-green-500">
                            Mettre à jour mon profil
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center mb-3">
                            <svg class="h-6 w-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3 class="text-sm font-medium text-blue-900">Participer aux discussions</h3>
                        </div>
                        <p class="text-sm text-blue-700">Échangez avec d'autres membres et partagez votre expérience pour augmenter votre visibilité.</p>
                        <a href="{{ route('messages.index') }}" class="mt-3 inline-flex items-center text-sm text-blue-600 hover:text-blue-500">
                            Voir mes messages
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Badges manquants -->
        <div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Badges à débloquer</h2>
                @if($missingBadges->count() > 0)
                    <div class="space-y-4">
                        @foreach($missingBadges as $badge)
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center mb-2">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-lg text-gray-400">{{ $badge->icon }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $badge->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $badge->description }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 border-t border-gray-200 pt-3">
                                    <h4 class="text-xs font-medium text-gray-900 mb-2">Comment l'obtenir :</h4>
                                    <p class="text-xs text-gray-600">{{ $badge->requirements }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Félicitations ! Vous avez obtenu tous les badges disponibles.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
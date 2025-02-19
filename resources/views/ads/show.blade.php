@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="py-6 bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Fil d'Ariane -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('ads.index') }}" class="inline-flex items-center text-sm font-medium text-[#157e74] hover:text-[#279078] transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Retour aux annonces
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-[#6dbaaf]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-[#157e74] md:ml-2">{{ $ad->category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Colonne de gauche: Images et détails -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white overflow-hidden shadow-lg rounded-2xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-[#157e74]">{{ $ad->title }}</h1>
                            
                        </div>

                        <!-- Images avec effet carousel -->
                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl overflow-hidden mb-6">
                            @if($ad->images && $ad->images->count() > 0)
                                <div class="relative"> 
                                    @foreach($ad->images as $image)
                                        <img src="{{ $image->url }}" 
                                             alt="Image de l'annonce" 
                                             class="w-full h-96 object-cover">
                                    @endforeach
                                </div>
                            @else
                                <div class="h-96 flex items-center justify-center">
                                    <p class="text-[#6dbaaf]">Aucune image disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Détails -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-xl font-semibold text-[#157e74] mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Description
                    </h2>
                    <p class="text-gray-700 mb-8 leading-relaxed">{{ $ad->description }}</p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 hover:from-[#157e74]/10 hover:to-[#a3cca8]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#157e74] mb-1">Catégorie</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->category->name }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 hover:from-[#157e74]/10 hover:to-[#a3cca8]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#157e74] mb-1">Type</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->type === 'goods' ? 'Bien' : 'Service' }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 hover:from-[#157e74]/10 hover:to-[#a3cca8]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#157e74] mb-1">Localisation</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->location }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 hover:from-[#157e74]/10 hover:to-[#a3cca8]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#157e74] mb-1">Échange en ligne</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->online_exchange ? 'Oui' : 'Non' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ce que recherche le vendeur -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <x-exchange-details :ad="$ad" />
                </div>
            </div>

            <!-- Colonne de droite: Profil vendeur et actions -->
            <div class="space-y-6">
                <!-- Profil vendeur -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-[#157e74] to-[#279078] px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">À propos du vendeur</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10 flex items-center justify-center text-[#157e74] text-2xl font-semibold">
                                {{ substr($ad->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $ad->user->name }}</h2>
                                <p class="text-sm text-[#6dbaaf]">Membre depuis {{ $ad->user->created_at->locale('fr')->format('M Y') }}</p>
                                <div class="mt-2 flex items-center">
                                    <div class="star-rating flex items-center">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="star h-5 w-5 {{ $i < $averageRating ? 'text-[#279078]' : 'text-gray-300' }}" data-rating="{{ $i }}" data-ad-id="{{ $ad->id }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-[#6dbaaf]">({{ $reviewsCount }} avis)</span>
                                </div>
                            </div>
                        </div>

                        @auth
                            @if(auth()->id() !== $ad->user_id)
                                <!-- Boutons d'action -->
                                <div class="space-y-4">
                                    <!-- Modal de contact -->
                                    <div x-data="{ open: false }">
                                        <!-- Bouton Contacter le vendeur -->
                                        <button @click="open = true" 
                                                class="w-full flex items-center justify-center px-4 py-2 bg-white border border-[#35a79b] rounded-lg text-[#35a79b] hover:bg-[#35a79b] hover:text-white transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            {{ __('Contacter le vendeur') }}
                                        </button>

                                        <!-- Modal -->
                                        <div x-show="open" 
                                             class="fixed inset-0 z-50 overflow-y-auto"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0">
                                            <div class="flex items-center justify-center min-h-screen px-4">
                                                <!-- Overlay -->
                                                <div class="fixed inset-0 bg-black opacity-50"></div>

                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full" @click.away="open = false">
                                                    <div class="px-6 py-4">
                                                        <div class="flex items-center justify-between mb-4">
                                                            <h3 class="text-lg font-medium text-gray-900">{{ __('Envoyer un message') }}</h3>
                                                            <button @click="open = false" class="text-gray-400 hover:text-gray-500">
                                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <form action="{{ route('messages.contact.seller', $ad->user) }}" method="POST" class="space-y-4">
                                                            @csrf
                                                            <div>
                                                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">{{ __('Votre message') }}</label>
                                                                <textarea
                                                                    name="message"
                                                                    id="message"
                                                                    rows="4"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#35a79b] focus:border-[#35a79b] @error('message') border-red-500 @enderror"
                                                                    placeholder="{{ __('Écrivez votre message ici...') }}"
                                                                    required
                                                                    minlength="2"
                                                                    maxlength="1000"
                                                                >{{ old('message') }}</textarea>
                                                                @error('message')
                                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                                @enderror
                                                            </div>

                                                            @if(session('error'))
                                                                <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                                                    <div class="flex">
                                                                        <div class="flex-shrink-0">
                                                                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="ml-3">
                                                                            <p class="text-sm text-red-600">{{ session('error') }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <div class="flex justify-end space-x-3">
                                                                <button type="button" 
                                                                        @click="open = false"
                                                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                                                    {{ __('Annuler') }}
                                                                </button>
                                                                <button type="submit"
                                                                        class="px-4 py-2 bg-[#35a79b] text-white rounded-lg hover:bg-[#2c8a7e] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b]">
                                                                    {{ __('Envoyer') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" onclick="openPropositionModal()" 
                                            class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Faire une proposition d'échange
                                    </button>
                                </div>

                                <!-- Informations supplémentaires -->
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 text-center">
                                            <span class="block text-sm text-[#157e74]">Publié le</span>
                                            <span class="block mt-1 font-medium text-gray-900">{{ $ad->created_at->locale('fr')->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-4 text-center">
                                            <span class="block text-sm text-[#157e74]">Vues</span>
                                            <span class="block mt-1 font-medium text-gray-900">{{ $ad->views_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-6 text-center">
                                <svg class="h-12 w-12 mx-auto text-[#157e74] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <p class="text-gray-600 mb-4">Connectez-vous pour contacter le vendeur et faire des propositions d'échange</p>
                                <a href="{{ route('login') }}" 
                                   class="inline-block px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Se connecter
                                </a>
                            </div>
                        @endauth

                <!-- Signaler l'annonce -->
                @auth
                    @if(auth()->id() !== $ad->user_id)
                                <div class="mt-4 text-center">
                                    <button type="button" onclick="openReportModal()" 
                                            class="inline-flex items-center text-sm text-[#6dbaaf] hover:text-red-600 transition-colors duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Signaler cette annonce
                            </button>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('ads.partials.message-modal')
@include('ads.partials.proposition-modal')
@include('ads.partials.report-modal')

@endsection 
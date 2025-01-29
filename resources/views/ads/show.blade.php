@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="py-6 bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Fil d'Ariane -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('ads.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#35a79b]">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Accueil
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-[#35a79b] md:ml-2">{{ $ad->category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Colonne de gauche: Images et détails -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <h1 class="text-2xl font-extrabold text-[#35a79b] mb-4">{{ $ad->title }}</h1>

                        <!-- Images avec effet carousel -->
                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl overflow-hidden mb-6">
                            @if($ad->images && $ad->images->count() > 0)
                                <div class="relative">
                                    @foreach($ad->images as $image)
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="Image de l'annonce" 
                                             class="w-full h-96 object-cover">
                                    @endforeach
                                </div>
                            @else
                                <div class="h-96 flex items-center justify-center">
                                    <p class="text-gray-500">Aucune image disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Détails -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-xl font-semibold text-[#35a79b] mb-6">Description</h2>
                    <p class="text-gray-700 mb-8 leading-relaxed">{{ $ad->description }}</p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 hover:from-[#35a79b]/10 hover:to-[#79d8b2]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#35a79b] mb-1">Catégorie</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->category->name }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 hover:from-[#35a79b]/10 hover:to-[#79d8b2]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#35a79b] mb-1">Type</h3>
                            <p class="text-base font-medium text-gray-900">{{ ucfirst($ad->type) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 hover:from-[#35a79b]/10 hover:to-[#79d8b2]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#35a79b] mb-1">Localisation</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->location }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 hover:from-[#35a79b]/10 hover:to-[#79d8b2]/10 transition-colors duration-200">
                            <h3 class="text-sm font-medium text-[#35a79b] mb-1">Échange en ligne</h3>
                            <p class="text-base font-medium text-gray-900">{{ $ad->online_exchange ? 'Oui' : 'Non' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ce que recherche le vendeur -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-xl font-semibold text-[#35a79b] mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#79d8b2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Ce que recherche le vendeur
                    </h2>
                    <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-6">
                        <p class="text-gray-700 leading-relaxed">{{ $ad->exchange_with }}</p>
                    </div>
                </div>
            </div>

            <!-- Colonne de droite: Profil vendeur et actions -->
            <div class="space-y-6">
                <!-- Profil vendeur -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-[#35a79b] to-[#79d8b2] px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">À propos du vendeur</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="h-20 w-20 rounded-xl bg-gradient-to-br from-[#35a79b]/10 to-[#79d8b2]/10 flex items-center justify-center text-[#35a79b] text-2xl font-semibold">
                                {{ substr($ad->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-semibold text-gray-900">{{ $ad->user->name }}</h2>
                                <p class="text-sm text-gray-500">Membre depuis {{ $ad->user->created_at->format('M Y') }}</p>
                                <div class="mt-2 flex items-center">
                                    <div class="star-rating flex items-center">
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="star h-5 w-5 {{ $i < $averageRating ? 'text-[#79d8b2]' : 'text-gray-300' }}" data-rating="{{ $i }}" data-ad-id="{{ $ad->id }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">({{ $reviewsCount }} avis)</span>
                                </div>
                            </div>
                        </div>

                        @auth
                            @if(auth()->id() !== $ad->user_id)
                                <!-- Boutons d'action -->
                                <div class="space-y-4">
                                    <button type="button" onclick="openMessageModal()" class="w-full flex justify-center items-center px-6 py-3 border-2 border-[#79d8b2] shadow-sm text-base font-medium rounded-xl text-[#35a79b] bg-white hover:bg-[#35a79b]/5 transition-all duration-200 transform hover:-translate-y-0.5">
                                        <svg class="h-5 w-5 mr-3 text-[#79d8b2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Contacter le vendeur
                                    </button>

                                    <button type="button" onclick="openPropositionModal()" class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-[#35a79b] to-[#79d8b2] hover:from-[#35a79b]/90 hover:to-[#79d8b2]/90 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Faire une proposition d'échange
                                    </button>
                                </div>

                                <!-- Informations supplémentaires -->
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 text-center">
                                            <span class="block text-sm text-[#35a79b]">Publié le</span>
                                            <span class="block mt-1 font-medium text-gray-900">{{ $ad->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-4 text-center">
                                            <span class="block text-sm text-[#35a79b]">Vues</span>
                                            <span class="block mt-1 font-medium text-gray-900">{{ $ad->views_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 rounded-xl p-6 text-center">
                                <svg class="h-12 w-12 mx-auto text-[#35a79b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <p class="text-gray-600 mb-4">Connectez-vous pour contacter le vendeur et faire des propositions d'échange</p>
                                <a href="{{ route('login') }}" class="inline-block px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-[#35a79b] to-[#79d8b2] hover:from-[#35a79b]/90 hover:to-[#79d8b2]/90 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Se connecter
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Signaler l'annonce -->
                @auth
                    @if(auth()->id() !== $ad->user_id)
                        <div class="bg-white rounded-xl shadow-lg p-4 text-center">
                            <button type="button" onclick="openReportModal()" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 transition-colors duration-200">
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

<!-- Modal Message -->
<div id="messageModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="messageModalContent">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-[#35a79b]">Envoyer un message</h3>
                <button type="button" onclick="closeMessageModal()" class="text-gray-400 hover:text-[#35a79b] transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('messages.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $ad->user_id }}">
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-[#35a79b] mb-2">Votre message</label>
                    <textarea name="content" id="content" rows="4" class="shadow-sm block w-full focus:ring-[#35a79b] focus:border-[#35a79b] sm:text-sm border-gray-300 rounded-xl" required placeholder="Écrivez votre message ici..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeMessageModal()" class="px-4 py-2 border-2 border-[#79d8b2] shadow-sm text-sm font-medium rounded-xl text-[#35a79b] bg-white hover:bg-[#35a79b]/5 transition-all duration-200">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-[#35a79b] to-[#79d8b2] hover:from-[#35a79b]/90 hover:to-[#79d8b2]/90 transition-all duration-200">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Proposition -->
<div id="propositionModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0" id="propositionModalContent">
            <div class="flex justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-[#35a79b]">Faire une proposition d'échange</h3>
                <button type="button" onclick="closePropositionModal()" class="text-gray-400 hover:text-[#35a79b] transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('propositions.store', $ad) }}" method="POST" class="p-6">
                @csrf
                
                <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                <div class="space-y-6">
                    <div>
                        <label for="offer" class="block text-sm font-medium text-[#35a79b] mb-2">Votre offre</label>
                        <textarea name="offer" id="offer" rows="4" class="shadow-sm block w-full focus:ring-[#35a79b] focus:border-[#35a79b] sm:text-sm border-gray-300 rounded-xl" required placeholder="Décrivez en détail ce que vous proposez en échange..."></textarea>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-[#35a79b] mb-2">Message complémentaire (optionnel)</label>
                        <textarea name="message" id="message" rows="2" class="shadow-sm block w-full focus:ring-[#35a79b] focus:border-[#35a79b] sm:text-sm border-gray-300 rounded-xl" placeholder="Ajoutez des informations supplémentaires..."></textarea>
                    </div>
                    <div class="bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5 p-6 rounded-xl">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="online_exchange" id="online_exchange" value="1" class="h-4 w-4 text-[#35a79b] focus:ring-[#35a79b] border-gray-300 rounded">
                            <label for="online_exchange" class="ml-2 block text-sm text-gray-700">Je souhaite faire l'échange en ligne</label>
                        </div>
                        <div id="meetingDetails" class="space-y-4">
                            <div>
                                <label for="meeting_location" class="block text-sm font-medium text-[#35a79b] mb-2">Lieu de rencontre proposé</label>
                                <input type="text" name="meeting_location" id="meeting_location" class="shadow-sm block w-full focus:ring-[#35a79b] focus:border-[#35a79b] sm:text-sm border-gray-300 rounded-xl" placeholder="Ex: Centre commercial, Gare...">
                            </div>
                            <div>
                                <label for="meeting_date" class="block text-sm font-medium text-[#35a79b] mb-2">Date et heure de rencontre souhaitées</label>
                                <input type="datetime-local" name="meeting_date" id="meeting_date" class="shadow-sm block w-full focus:ring-[#35a79b] focus:border-[#35a79b] sm:text-sm border-gray-300 rounded-xl">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closePropositionModal()" class="px-4 py-2 border-2 border-[#79d8b2] shadow-sm text-sm font-medium rounded-xl text-[#35a79b] bg-white hover:bg-[#35a79b]/5 transition-all duration-200">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-[#35a79b] to-[#79d8b2] hover:from-[#35a79b]/90 hover:to-[#79d8b2]/90 transition-all duration-200">
                        Envoyer la proposition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openMessageModal() {
        const modal = document.getElementById('messageModal');
        const content = document.getElementById('messageModalContent');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Animation d'entrée
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeMessageModal() {
        const modal = document.getElementById('messageModal');
        const content = document.getElementById('messageModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    function openPropositionModal() {
        const modal = document.getElementById('propositionModal');
        const content = document.getElementById('propositionModalContent');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Animation d'entrée
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closePropositionModal() {
        const modal = document.getElementById('propositionModal');
        const content = document.getElementById('propositionModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    // Gestion de l'affichage des détails de rencontre
    document.getElementById('online_exchange').addEventListener('change', function() {
        const meetingDetails = document.getElementById('meetingDetails');
        if (this.checked) {
            meetingDetails.classList.add('hidden');
        } else {
            meetingDetails.classList.remove('hidden');
        }
    });

    // Fermeture des modales en cliquant en dehors
    window.onclick = function(event) {
        const messageModal = document.getElementById('messageModal');
        const propositionModal = document.getElementById('propositionModal');
        
        if (event.target === messageModal) {
            closeMessageModal();
        }
        if (event.target === propositionModal) {
            closePropositionModal();
        }
    }

    // Animation des images au survol
    document.querySelectorAll('.carousel-thumbnail').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const mainImage = document.querySelector('.main-image');
            const newSrc = this.getAttribute('src');
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.setAttribute('src', newSrc);
                mainImage.style.opacity = '1';
            }, 200);
        });
    });


    // rating 
    document.querySelectorAll('.star-rating .star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = parseInt(this.getAttribute('data-rating')) + 1; // Les étoiles commencent à 0
        const adId = this.getAttribute('data-ad-id');

        // Récupérez le rating actuel
        let currentRating = Array.from(document.querySelectorAll('.star-rating .star'))
            .filter(star => star.classList.contains('text-[#79d8b2]')).length;

        // Vérifiez si l'étoile cliquée est déjà active
        const isActive = this.classList.contains('text-[#79d8b2]');
        let newRating;

        if (isActive) {
            // Retirer le rating de cette étoile
            newRating = currentRating - 1; // Décrémenter le rating
        } else {
            // Ajouter le rating de cette étoile
            newRating = currentRating + 1; // Incrémenter le rating
        }

        fetch(`/ads/${adId}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ rating: newRating }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log("Rating updated successfully");
                updateStarColors(newRating); // Mettez à jour les étoiles
            } else {
                console.error("Error:", data.error);
            }
        })
        .catch(error => {
            console.error('Error updating rating:', error);
        });
    });
});

function updateStarColors(rating) {
    const stars = document.querySelectorAll('.star-rating .star');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('text-[#79d8b2]'); // Couleur verte
            star.classList.remove('text-gray-300'); // Couleur grise
        } else {
            star.classList.remove('text-[#79d8b2]');
            star.classList.add('text-gray-300');
        }
    });
}

// document.addEventListener('DOMContentLoaded', function() {
//     const onlineExchangeCheckbox = document.getElementById('online_exchange');
//     const meetingLocationField = document.getElementById('meeting_location').closest('.form-group');
//     const meetingDateField = document.getElementById('meeting_date').closest('.form-group');

//     function toggleMeetingFields() {
//         if (onlineExchangeCheckbox.checked) {
//             meetingLocationField.style.display = 'none';
//             meetingDateField.style.display = 'none';
//             document.getElementById('meeting_location').value = '';
//             document.getElementById('meeting_date').value = '';
//         } else {
//             meetingLocationField.style.display = 'block';
//             meetingDateField.style.display = 'block';
//         }
//     }

//     onlineExchangeCheckbox.addEventListener('change', toggleMeetingFields);
//     toggleMeetingFields(); // Initial call to set the correct state
// });

document.addEventListener('DOMContentLoaded', function() {
    const onlineExchangeCheckbox = document.getElementById('online_exchange');
    const meetingLocationField = document.getElementById('meeting_location').closest('.form-group');
    const meetingDateField = document.getElementById('meeting_date').closest('.form-group');

    function toggleMeetingFields() {
        if (onlineExchangeCheckbox.checked) {
            meetingLocationField.style.display = 'none';
            meetingDateField.style.display = 'none';
            document.getElementById('meeting_location').value = '';
            document.getElementById('meeting_date').value = '';
        } else {
            meetingLocationField.style.display = 'block';
            meetingDateField.style.display = 'block';
        }
    }

    onlineExchangeCheckbox.addEventListener('change', toggleMeetingFields);
    toggleMeetingFields(); // Initial call to set the correct state
});
</script>
@endpush
@endsection 
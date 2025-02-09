@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- En-tête avec retour -->
        <div class="mb-6">
            <a href="{{ route('propositions.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Retour aux propositions') }}
            </a>
        </div>

        <!-- En-tête de la proposition avec statut -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-[#35a79b] bg-opacity-10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#35a79b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $proposition->ad->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ __('Proposé par') }} {{ $proposition->user->name }} • {{ $proposition->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($proposition->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                        @elseif($proposition->status === 'accepted') bg-green-100 text-green-800 border border-green-200
                        @elseif($proposition->status === 'rejected') bg-red-100 text-red-800 border border-red-200
                        @else bg-gray-100 text-gray-800 border border-gray-200
                        @endif">
                        <svg class="w-4 h-4 mr-2
                            @if($proposition->status === 'pending') text-yellow-500
                            @elseif($proposition->status === 'accepted') text-green-500
                            @elseif($proposition->status === 'rejected') text-red-500
                            @else text-gray-500
                            @endif" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($proposition->status === 'pending')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @elseif($proposition->status === 'accepted')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            @elseif($proposition->status === 'rejected')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                        {{ ucfirst($proposition->status) }}
                    </span>
                    @if($proposition->isAccepted() && !$proposition->isCompleted() && (Auth::id() === $proposition->user_id || Auth::id() === $proposition->ad->user_id))
                        <button onclick="showCompleteModal()" 
                                class="inline-flex items-center px-6 py-3 bg-[#35a79b] text-white rounded-lg hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] transition-colors duration-200 shadow-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            {{ __('Marquer comme complété') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Colonne de gauche : Détails de l'annonce -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    @if($proposition->ad->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $proposition->ad->images->first()->image_path) }}" 
                             alt="{{ $proposition->ad->title }}" 
                             class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 bg-gray-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex flex-col space-y-4">
                        <p class="text-gray-600 leading-relaxed">{{ $proposition->ad->description }}</p>
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-4">
                                @if($proposition->ad->warranty)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-[#35a79b] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        {{ __('Garantie') }}
                                    </div>
                                @endif
                                @if($proposition->ad->energy_class)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-[#35a79b] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        {{ __('Classe') }} {{ $proposition->ad->energy_class }}
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('ads.show', $proposition->ad) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 text-sm transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('Voir l\'annonce') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne du milieu : Détails de la proposition -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="space-y-6">
                    <!-- Offre proposée -->
                    <div class="bg-[#35a79b] bg-opacity-5 rounded-lg p-4 border border-[#35a79b] border-opacity-20">
                        <div class="flex items-center mb-3">
                            <svg class="w-6 h-6 text-[#35a79b] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h4 class="text-base font-semibold text-gray-900">{{ __('Offre proposée') }}</h4>
                        </div>
                        <p class="text-gray-700">{{ $proposition->offer }}</p>
                    </div>

                    <!-- Message -->
                    @if($proposition->message)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <h4 class="text-base font-semibold text-gray-900">{{ __('Message') }}</h4>
                            </div>
                            <p class="text-gray-700">{{ $proposition->message }}</p>
                        </div>
                    @endif

                    <!-- Détails du rendez-vous -->
                    @if($proposition->meeting_location || $proposition->meeting_date)
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <h4 class="text-base font-semibold text-gray-900">{{ __('Détails du rendez-vous') }}</h4>
                            </div>
                            <div class="space-y-3">
                                @if($proposition->meeting_location)
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        {{ $proposition->meeting_location }}
                                    </div>
                                @endif
                                @if($proposition->meeting_date)
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $proposition->meeting_date->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if($proposition->isPending() && Auth::id() === $proposition->ad->user_id)
                        <div class="flex justify-end space-x-4 pt-4 border-t border-gray-100">
                            <button onclick="showAcceptModal()" 
                                    class="inline-flex items-center px-6 py-3 bg-[#35a79b] text-white rounded-lg hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('Accepter') }}
                            </button>
                            <button onclick="showRejectModal()"
                                    class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 shadow-sm">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ __('Refuser') }}
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Colonne de droite : Profil utilisateur et messagerie -->
            <div class="space-y-6">
                <!-- Carte de l'utilisateur -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            @if($proposition->user->profile_photo_path)
                                <img class="h-16 w-16 rounded-full object-cover border-4 border-[#35a79b] border-opacity-20" 
                                     src="{{ asset('storage/' . $proposition->user->profile_photo_path) }}" 
                                     alt="{{ $proposition->user->name }}">
                            @else
                                <div class="h-16 w-16 rounded-full bg-[#35a79b] bg-opacity-10 flex items-center justify-center border-4 border-[#35a79b] border-opacity-20">
                                    <svg class="w-8 h-8 text-[#35a79b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $proposition->user->name }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ __('Membre depuis') }} {{ $proposition->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <dt class="text-sm font-medium text-gray-500 mb-1">{{ __('Échanges réalisés') }}</dt>
                            <dd class="text-2xl font-bold text-[#35a79b]">{{ $proposition->user->propositions()->count() }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <dt class="text-sm font-medium text-gray-500 mb-1">{{ __('Note moyenne') }}</dt>
                            <dd class="flex items-center justify-center">
                                <span class="text-2xl font-bold text-[#35a79b] mr-2">4.5</span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </dd>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-[#35a79b] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Taux de réponse') }}: 90%
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 text-[#35a79b] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Temps de réponse moyen') }}: < 24h
                        </div>
                    </div>

                    <!-- Bouton de messagerie -->
                    <a href="{{ route('messages.show.direct', $proposition->user->id) }}" 
                       class="mt-6 w-full inline-flex items-center justify-center px-6 py-3 bg-[#35a79b] text-white rounded-lg hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] transition-colors duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        {{ __('Accéder à la messagerie') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de confirmation -->
@include('propositions.partials.modals')

@push('scripts')
<script>
function setRating(rating) {
    document.getElementById('rating-input').value = rating;
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < rating);
        star.classList.toggle('text-gray-300', index >= rating);
    });
}

// Fonctions pour les modales
function showAcceptModal() {
    document.getElementById('accept-modal').classList.remove('hidden');
}

function hideAcceptModal() {
    document.getElementById('accept-modal').classList.add('hidden');
}

function showRejectModal() {
    document.getElementById('reject-modal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
}

function showCompleteModal() {
    document.getElementById('complete-modal').classList.remove('hidden');
}

function hideCompleteModal() {
    document.getElementById('complete-modal').classList.add('hidden');
}
</script>
@endpush

@endsection 
@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Mes propositions d\'échange') }}</h1>
            <a href="{{ route('ads.index') }}" class="inline-flex items-center px-4 py-2 bg-[#35a79b] text-white rounded-md hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('Parcourir les annonces') }}
            </a>
                </div>

                @if($propositions->isEmpty())
            <!-- État vide -->
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                        </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('Aucune proposition pour le moment') }}</h3>
                <p class="mt-2 text-gray-500">{{ __('Commencez à parcourir les annonces pour faire des propositions d\'échange.') }}</p>
                    </div>
                @else
            <!-- Liste des propositions -->
                    <div class="space-y-6">
                        @foreach($propositions as $proposition)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                        <!-- En-tête avec statut -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
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
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('propositions.show', $proposition) }}" class="hover:text-[#35a79b]">
                                                {{ $proposition->ad->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ __('Proposé par') }} {{ $proposition->user->name }} • {{ $proposition->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($proposition->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($proposition->status === 'accepted') bg-green-100 text-green-800
                                        @elseif($proposition->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($proposition->status) }}
                                    </span>
                                </div>
                                </div>

                        <!-- Contenu principal -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Offre proposée -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h4 class="text-sm font-medium text-gray-900">{{ __('Offre proposée') }}</h4>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ Str::limit($proposition->offer, 200) }}</p>
                                </div>

                                <!-- Message ou Détails d'échange -->
                                @if($proposition->isAccepted())
                                    <div class="bg-green-50 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <h4 class="text-sm font-medium text-green-900">{{ __('Détails de l\'échange') }}</h4>
                                        </div>
                                        <div class="space-y-2">
                                                    @if($proposition->online_exchange)
                                                <div class="flex items-center text-sm text-green-700">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                    </svg>
                                                    {{ __('Échange en ligne') }}
                                                </div>
                                                    @else
                                                <div class="flex items-center text-sm text-green-700">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    {{ $proposition->meeting_location }}
                                                </div>
                                                @if($proposition->meeting_date)
                                                    <div class="flex items-center text-sm text-green-700">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        {{ $proposition->meeting_date->format('d/m/Y H:i') }}
                                                    </div>
                                                    @endif
                                            @endif
                                        </div>
                                    </div>
                                @elseif($proposition->message)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center mb-3">
                                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                            </svg>
                                            <h4 class="text-sm font-medium text-gray-900">{{ __('Message') }}</h4>
                                        </div>
                                        <p class="text-sm text-gray-600">{{ Str::limit($proposition->message, 200) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                            <div class="flex justify-end items-center space-x-4">
                                <!-- Bouton Voir plus de détails -->
                                <a href="{{ route('propositions.show', $proposition) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ __('Détails') }}
                                    </a>

                                    @if($proposition->isPending() && Auth::id() === $proposition->ad->user_id)
                                        <form action="{{ route('propositions.accept', $proposition) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#35a79b] text-white rounded-md hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b]">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Accepter') }}
                                            </button>
                                        </form>

                                        <form action="{{ route('propositions.reject', $proposition) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            {{ __('Refuser') }}
                                            </button>
                                        </form>
                                    @endif
                            </div>
                                </div>
                            </div>
                        @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                            {{ $propositions->links() }}
                        </div>
                    </div>
                @endif
    </div>
</div>
@endsection 
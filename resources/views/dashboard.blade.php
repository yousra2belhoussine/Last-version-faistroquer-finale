@extends('layouts.app')

@section('content')
<div class="py-6 bg-gradient-to-br from-[#35a79b]/5 to-[#79d8b2]/5">
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
        <!-- Welcome Section -->
        <div class="mb-4 bg-white p-6 rounded-xl shadow-lg">
            <h1 class="text-2xl font-extrabold text-[#35a79b]">{{ __('Bienvenue') }}, {{ auth()->user()->name }} !</h1>
            <p class="mt-1 text-[#79d8b2]">{{ __('Voici ce qui se passe avec votre compte.') }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Main Content (Left and Middle Columns) -->
            <div class="lg:col-span-2 space-y-4">
                <!-- Proposition Statistics -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <h2 class="text-xl font-extrabold text-[#35a79b] mb-4">{{ __('Activité d\'échange') }}</h2>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-gradient-to-br from-[#f31f7a1]/20 to-[#f6c146]/20 p-4 rounded-lg border border-[#f6c146]">
                                <div class="text-xl font-bold text-[#35a79b]">{{ $propositionStats['pending'] }}</div>
                                <div class="text-sm text-[#79d8b2]">{{ __('En attente') }}</div>
                            </div>
                            <div class="bg-gradient-to-br from-[#79d8b2]/20 to-[#35a79b]/20 p-4 rounded-lg border border-[#79d8b2]">
                                <div class="text-xl font-bold text-[#35a79b]">{{ $propositionStats['accepted'] }}</div>
                                <div class="text-sm text-[#79d8b2]">{{ __('Acceptées') }}</div>
                            </div>
                            <div class="bg-gradient-to-br from-[#f6c146]/20 to-[#f45157]/20 p-4 rounded-lg border border-[#f6c146]">
                                <div class="text-xl font-bold text-[#35a79b]">{{ $propositionStats['completed'] }}</div>
                                <div class="text-sm text-[#79d8b2]">{{ __('Complétées') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Section -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <h2 class="text-xl font-extrabold text-[#35a79b]">{{ __('Messages récents') }}</h2>
                                @if($unreadCount > 0)
                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#f45157] text-white">
                                        {{ $unreadCount }} {{ __('non lu(s)') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($recentMessages->isEmpty())
                            <p class="text-[#79d8b2] text-center py-3">{{ __('Pas encore de messages.') }}</p>
                        @else
                            <div class="space-y-3 mb-4">
                                @foreach($recentMessages as $message)
                                    <a href="{{ $message['type'] === 'proposition' ? route('messages.show', $message['id']) : route('messages.show.direct', $message['other_user']['id']) }}" 
                                       class="block border border-[#79d8b2] rounded-lg p-3 hover:bg-[#f31f7a1]/5 transition-all duration-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full bg-[#35a79b] flex items-center justify-center text-white font-semibold">
                                                    {{ substr($message['other_user']['name'], 0, 1) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="font-medium text-[#35a79b]">{{ $message['other_user']['name'] }}</p>
                                                    @if($message['ad'])
                                                        <p class="text-sm text-[#79d8b2]">{{ $message['ad']['title'] }}</p>
                                                    @else
                                                        <p class="text-sm text-[#79d8b2]">{{ __('Message direct') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @unless($message['is_read'])
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-[#f45157] text-white">
                                                    {{ __('Nouveau') }}
                                                </span>
                                            @endunless
                                        </div>
                                        <p class="text-sm text-[#79d8b2] truncate">{{ $message['content'] }}</p>
                                        <p class="text-xs text-[#79d8b2]/60 mt-1">{{ $message['created_at']->diffForHumans() }}</p>
                                    </a>
                                @endforeach
                            </div>
                            
                            <div class="text-center">
                                <a href="{{ route('messages.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-[#35a79b] rounded-full text-sm font-medium text-[#35a79b] bg-white hover:bg-[#f31f7a1]/10 transition-all duration-200">
                                    {{ __('Voir tous les messages') }}
                                    @if($unreadCount > 0)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#f45157] text-white">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                    <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-4">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <h2 class="text-xl font-extrabold text-[#35a79b] mb-4">{{ __('Actions rapides') }}</h2>
                        <div class="space-y-3">
                            <a href="{{ route('ads.create') }}" class="block p-4 bg-gradient-to-br from-[#35a79b]/10 to-[#79d8b2]/10 border border-[#79d8b2] rounded-lg hover:bg-[#f31f7a1]/10 transition-all duration-200 group">
                                <h3 class="text-lg font-semibold text-[#35a79b] group-hover:translate-x-1 transition-transform duration-200">{{ __('Publier une annonce') }}</h3>
                                <p class="text-[#79d8b2] text-sm">{{ __('Créer une nouvelle annonce pour échanger.') }}</p>
                            </a>

                            <a href="{{ route('ads.my-ads') }}" class="block p-4 bg-gradient-to-br from-[#f6c146]/10 to-[#f31f7a1]/10 border border-[#f6c146] rounded-lg hover:bg-[#f31f7a1]/10 transition-all duration-200 group">
                                <h3 class="text-lg font-semibold text-[#35a79b] group-hover:translate-x-1 transition-transform duration-200">{{ __('Mes annonces') }}</h3>
                                <p class="text-[#79d8b2] text-sm">{{ __('Gérer vos annonces publiées.') }}</p>
                            </a>

                            <a href="{{ route('propositions.index') }}" class="block p-4 bg-gradient-to-br from-[#f45157]/10 to-[#f6c146]/10 border border-[#f45157] rounded-lg hover:bg-[#f31f7a1]/10 transition-all duration-200 group">
                                <h3 class="text-lg font-semibold text-[#35a79b] group-hover:translate-x-1 transition-transform duration-200">{{ __('Propositions') }}</h3>
                                <p class="text-[#79d8b2] text-sm">{{ __('Voir et gérer les propositions d\'échange.') }}</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <h2 class="text-xl font-extrabold text-[#35a79b] mb-4">{{ __('Informations du profil') }}</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="h-14 w-14 rounded-full bg-[#f6c146] flex items-center justify-center text-xl font-bold text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-[#35a79b]">{{ auth()->user()->name }}</h3>
                                    <p class="text-sm text-[#79d8b2]">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <a href="{{ route('profile.edit') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-[#35a79b] rounded-full text-sm font-medium text-[#35a79b] bg-white hover:bg-[#f31f7a1]/10 transition-all duration-200">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ __('Modifier le profil') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Stats -->
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-6">
                        <h2 class="text-xl font-extrabold text-[#35a79b] mb-4">{{ __('Autres statistiques') }}</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gradient-to-br from-[#f31f7a1]/10 to-[#f6c146]/10 rounded-lg">
                                <span class="text-[#79d8b2]">{{ __('Total des propositions') }}</span>
                                <span class="font-semibold text-[#35a79b]">{{ $propositionStats['total'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gradient-to-br from-[#f45157]/10 to-[#f6c146]/10 rounded-lg">
                                <span class="text-[#79d8b2]">{{ __('Refusées') }}</span>
                                <span class="font-semibold text-[#35a79b]">{{ $propositionStats['rejected'] }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gradient-to-br from-[#79d8b2]/10 to-[#35a79b]/10 rounded-lg">
                                <span class="text-[#79d8b2]">{{ __('Annulées') }}</span>
                                <span class="font-semibold text-[#35a79b]">{{ $propositionStats['cancelled'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
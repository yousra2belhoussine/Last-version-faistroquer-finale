@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 bg-gradient-to-br from-[#edf7f6] to-[#e5f5f3]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête compact -->
        <div class="mb-6 p-6 bg-white rounded-xl shadow-sm border border-[#35a79b]/20">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-16 w-16 rounded-full object-cover ring-4 ring-[#35a79b]/20">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] flex items-center justify-center text-xl font-bold text-white shadow-md">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h1 class="text-xl font-bold text-[#2c8a7e]">{{ auth()->user()->name }}</h1>
                        <p class="text-sm text-[#35a79b]/70">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-[#35a79b] to-[#2c8a7e] rounded-lg hover:from-[#2c8a7e] hover:to-[#35a79b] transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Modifier le profil') }}
                </a>
            </div>
        </div>

        <!-- Actions rapides en haut -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('ads.create.step1') }}" 
               class="flex items-center p-4 bg-gradient-to-br from-[#35a79b]/10 to-[#2c8a7e]/10 rounded-xl border border-[#35a79b]/20 hover:shadow-md hover:border-[#35a79b]/40 transition-all duration-200">
                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-medium text-[#2c8a7e]">{{ __('Publier une annonce') }}</h3>
                    <p class="text-sm text-[#35a79b]/70">{{ __('Créer une nouvelle annonce') }}</p>
                </div>
            </a>

            <a href="{{ route('ads.my-ads') }}" 
               class="flex items-center p-4 bg-gradient-to-br from-[#f6c146]/10 to-[#f45157]/10 rounded-xl border border-[#f6c146]/20 hover:shadow-md hover:border-[#f6c146]/40 transition-all duration-200">
                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-gradient-to-br from-[#f6c146] to-[#f45157] text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-medium text-[#f45157]">{{ __('Mes annonces') }}</h3>
                    <p class="text-sm text-[#f45157]/70">{{ __('Gérer vos annonces') }}</p>
                </div>
            </a>

            <a href="{{ route('propositions.index') }}" 
               class="flex items-center p-4 bg-gradient-to-br from-[#79d8b2]/10 to-[#35a79b]/10 rounded-xl border border-[#79d8b2]/20 hover:shadow-md hover:border-[#79d8b2]/40 transition-all duration-200">
                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-lg bg-gradient-to-br from-[#79d8b2] to-[#35a79b] text-white shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-medium text-[#35a79b]">{{ __('Propositions') }}</h3>
                    <p class="text-sm text-[#35a79b]/70">{{ __('Gérer les échanges') }}</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Statistiques et Messages (Colonne principale) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statistiques -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-[#35a79b]/20">
                    <h2 class="text-lg font-medium text-[#2c8a7e] mb-4">{{ __('Aperçu des échanges') }}</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-gradient-to-br from-[#35a79b]/10 to-[#2c8a7e]/10 rounded-xl border border-[#35a79b]/20">
                            <div class="text-2xl font-bold text-[#2c8a7e]">{{ $propositionStats['pending'] }}</div>
                            <div class="text-sm text-[#35a79b]/70">{{ __('En attente') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-br from-[#f6c146]/10 to-[#f45157]/10 rounded-xl border border-[#f6c146]/20">
                            <div class="text-2xl font-bold text-[#f45157]">{{ $propositionStats['accepted'] }}</div>
                            <div class="text-sm text-[#f45157]/70">{{ __('Acceptées') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-br from-[#79d8b2]/10 to-[#35a79b]/10 rounded-xl border border-[#79d8b2]/20">
                            <div class="text-2xl font-bold text-[#35a79b]">{{ $propositionStats['completed'] }}</div>
                            <div class="text-sm text-[#35a79b]/70">{{ __('Complétées') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Messages récents -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-[#35a79b]/20">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-medium text-[#2c8a7e]">{{ __('Messages récents') }}</h2>
                            @if($unreadCount > 0)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-[#f45157] to-[#f6c146] text-white shadow-sm">
                                    {{ $unreadCount }} {{ __('non lu(s)') }}
                                </span>
                            @endif
                        </div>

                        @if($recentMessages->isEmpty())
                            <div class="text-center py-6">
                                <p class="text-[#35a79b]/70">{{ __('Pas encore de messages.') }}</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($recentMessages as $message)
                                    <a href="{{ $message['type'] === 'proposition' ? route('messages.show', $message['id']) : route('messages.show.direct', $message['other_user']['id']) }}" 
                                       class="block bg-gradient-to-br from-white to-[#35a79b]/5 rounded-xl border border-[#35a79b]/20 p-4 hover:shadow-md hover:border-[#35a79b]/40 transition-all duration-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center min-w-0">
                                                @if($message['other_user']['profile_photo_url'])
                                                    <img src="{{ $message['other_user']['profile_photo_url'] }}" 
                                                         alt="{{ $message['other_user']['name'] }}" 
                                                         class="h-10 w-10 rounded-full object-cover ring-2 ring-[#35a79b]/20">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] flex items-center justify-center text-sm font-medium text-white shadow-sm">
                                                        {{ substr($message['other_user']['name'], 0, 1) }}
                                                    </div>
                                                @endif
                                                <div class="ml-3 min-w-0">
                                                    <p class="text-sm font-medium text-[#2c8a7e] truncate">{{ $message['other_user']['name'] }}</p>
                                                    @if(isset($message['ad']) && $message['ad'])
                                                        <p class="text-xs text-[#35a79b]/70 truncate">{{ $message['ad']['title'] }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @unless($message['is_read'])
                                                <span class="ml-2 px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-[#35a79b] to-[#2c8a7e] text-white shadow-sm">
                                                    {{ __('Nouveau') }}
                                                </span>
                                            @endunless
                                        </div>
                                        <p class="mt-2 text-sm text-[#2c8a7e]/80 line-clamp-2">{{ $message['content'] }}</p>
                                        <p class="mt-1 text-xs text-[#35a79b]/60">{{ $message['created_at']->diffForHumans() }}</p>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-6 text-center">
                                <a href="{{ route('messages.index') }}" 
                                   class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-[#35a79b] to-[#2c8a7e] rounded-full hover:from-[#2c8a7e] hover:to-[#35a79b] transition-all duration-200 shadow-sm">
                                    {{ __('Voir tous les messages') }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistiques détaillées (Sidebar) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-[#35a79b]/20">
                <h2 class="text-lg font-medium text-[#2c8a7e] mb-4">{{ __('Statistiques détaillées') }}</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-br from-[#35a79b]/10 to-[#2c8a7e]/10 rounded-xl border border-[#35a79b]/20">
                        <span class="text-sm text-[#2c8a7e]">{{ __('Total des propositions') }}</span>
                        <span class="text-lg font-semibold text-[#2c8a7e]">{{ $propositionStats['total'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gradient-to-br from-[#f6c146]/10 to-[#f45157]/10 rounded-xl border border-[#f6c146]/20">
                        <span class="text-sm text-[#f45157]">{{ __('Refusées') }}</span>
                        <span class="text-lg font-semibold text-[#f45157]">{{ $propositionStats['rejected'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-gradient-to-br from-[#79d8b2]/10 to-[#35a79b]/10 rounded-xl border border-[#79d8b2]/20">
                        <span class="text-sm text-[#35a79b]">{{ __('Annulées') }}</span>
                        <span class="text-lg font-semibold text-[#35a79b]">{{ $propositionStats['cancelled'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
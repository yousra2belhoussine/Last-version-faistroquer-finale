@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-white">
    <!-- Sidebar -->
    <div class="w-96 border-r flex flex-col">
        <!-- User Profile Header -->
        <div class="p-4 border-b flex items-center justify-between">
            <div class="flex items-center">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="h-10 w-10 rounded-full object-cover ring-2 ring-[#35a79b]/20"
                         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                @else
                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] flex items-center justify-center text-sm font-medium text-white shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="ml-3">
                    <h2 class="font-semibold text-[#2c8a7e]">{{ auth()->user()->name }}</h2>
                    <p class="text-sm text-[#35a79b]/70">En ligne</p>
                </div>
            </div>
            <button class="text-[#35a79b]/70 hover:text-[#2c8a7e]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>
        </div>

        <!-- Search Bar -->
        <div class="p-4 border-b">
            <div class="relative">
                <input type="text" 
                       placeholder="Rechercher..." 
                       class="w-full pl-10 pr-4 py-2 rounded-lg border border-[#35a79b]/20 focus:ring-2 focus:ring-[#35a79b] focus:border-[#35a79b]">
                <svg class="w-5 h-5 text-[#35a79b]/40 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Chat Tabs -->
        <div class="flex border-b">
            <button class="flex-1 py-3 text-sm font-medium text-[#2c8a7e] border-b-2 border-[#35a79b]">Direct</button>
            <button class="flex-1 py-3 text-sm font-medium text-[#35a79b]/70 hover:text-[#2c8a7e]">Groupe</button>
        </div>

        <!-- Conversations List -->
        <div class="flex-1 overflow-y-auto">
            @foreach($conversations as $conversation)
                @php
                    $otherParticipant = $conversation->participants->where('id', '!=', auth()->id())->first();
                    $lastMessage = $conversation->messages->first();
                @endphp
                <a href="{{ route('messages.show', $conversation) }}" 
                   class="block p-4 hover:bg-[#35a79b]/5 {{ request()->route('conversation') && request()->route('conversation')->id === $conversation->id ? 'bg-[#35a79b]/10' : '' }}">
                    <div class="flex items-center">
                        @if($otherParticipant->profile_photo_path)
                            <img src="{{ asset('storage/' . $otherParticipant->profile_photo_path) }}" 
                                 alt="{{ $otherParticipant->name }}" 
                                 class="h-12 w-12 rounded-full object-cover ring-2 ring-[#35a79b]/20"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                        @else
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] flex items-center justify-center text-sm font-medium text-white shadow-sm">
                                {{ substr($otherParticipant->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-[#2c8a7e]">{{ $otherParticipant->name }}</h3>
                                @if($lastMessage)
                                    <span class="text-xs text-[#35a79b]/70">{{ $lastMessage->created_at->format('H:i') }}</span>
                                @endif
                            </div>
                            @if($lastMessage)
                                <p class="text-sm text-[#35a79b]/70 truncate">{{ $lastMessage->content }}</p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Welcome Screen -->
    <div class="flex-1 flex items-center justify-center bg-[#35a79b]/5">
        <div class="text-center">
            <div class="w-24 h-24 bg-[#35a79b]/10 rounded-full mx-auto flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-[#35a79b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <h2 class="text-xl font-semibold text-[#2c8a7e]">Bienvenue dans vos messages</h2>
            <p class="text-[#35a79b]/70 mt-2">Sélectionnez une conversation pour commencer à discuter</p>
        </div>
    </div>
</div>
@endsection 
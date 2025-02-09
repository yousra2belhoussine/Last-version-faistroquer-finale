@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-white">
        <!-- Sidebar -->
        <div class="w-96 border-r flex flex-col">
            <!-- User Profile Header -->
            <div class="p-4 border-b flex items-center justify-between">
                <div class="flex items-center">
                    @if(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full">
                    @else
                        <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-3">
                        <h2 class="font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-gray-600">En ligne</p>
                    </div>
                </div>
                <button class="text-gray-500 hover:text-gray-700">
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
                           class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Chat Tabs -->
            <div class="flex border-b">
                <button class="flex-1 py-3 text-sm font-medium text-emerald-600 border-b-2 border-emerald-500">Direct</button>
                <button class="flex-1 py-3 text-sm font-medium text-gray-500 hover:text-gray-700">Groupe</button>
            </div>

            <!-- Conversations List -->
            <div class="flex-1 overflow-y-auto">
                @foreach($conversations as $conv)
                    @php
                        $otherParticipant = $conv->participants->where('id', '!=', auth()->id())->first();
                    @endphp
                    <a href="{{ route('messages.show', $conv) }}" 
                       class="block p-4 hover:bg-gray-50 {{ $conv->id === $conversation->id ? 'bg-emerald-50' : '' }}">
                        <div class="flex items-center">
                            @if($otherParticipant->profile_photo_url)
                                <img src="{{ $otherParticipant->profile_photo_url }}" 
                                     alt="{{ $otherParticipant->name }}" 
                                     class="w-12 h-12 rounded-full">
                            @else
                                <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr($otherParticipant->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium text-gray-900">{{ $otherParticipant->name }}</h3>
                                    @if($conv->lastMessage)
                                        <span class="text-xs text-gray-500">{{ $conv->lastMessage->created_at->format('H:i') }}</span>
                                    @endif
                                </div>
                                @if($conv->lastMessage)
                                    <p class="text-sm text-gray-500 truncate">{{ $conv->lastMessage->content }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col h-screen">
            <!-- Chat Header -->
            <div class="p-4 border-b flex items-center justify-between bg-white">
                <div class="flex items-center">
                    @php
                        $otherParticipant = $conversation->participants->where('id', '!=', auth()->id())->first();
                    @endphp
                    @if($otherParticipant->profile_photo_url)
                        <img src="{{ $otherParticipant->profile_photo_url }}" 
                             alt="{{ $otherParticipant->name }}" 
                             class="w-10 h-10 rounded-full">
                    @else
                        <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold">
                            {{ substr($otherParticipant->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h2 class="font-semibold text-gray-800">{{ $otherParticipant->name }}</h2>
                        <p class="text-sm text-gray-600">En ligne</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                @if($messages->isEmpty())
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Pas encore de messages</h3>
                        <p class="text-gray-500 mt-1">Commencez la conversation !</p>
                    </div>
                @else
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="flex items-end {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                @if($message->sender_id !== auth()->id())
                                    @if($message->sender->profile_photo_url)
                                        <img src="{{ $message->sender->profile_photo_url }}" 
                                             alt="{{ $message->sender->name }}" 
                                             class="w-8 h-8 rounded-full {{ $message->sender_id === auth()->id() ? 'ml-2' : 'mr-2' }}">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-sm font-semibold {{ $message->sender_id === auth()->id() ? 'ml-2' : 'mr-2' }}">
                                            {{ substr($message->sender->name, 0, 1) }}
                                        </div>
                                    @endif
                                @endif
                                <div class="{{ $message->sender_id === auth()->id() ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg px-4 py-2 max-w-md">
                                    <p class="text-sm">{{ $message->content }}</p>
                                    <p class="text-xs {{ $message->sender_id === auth()->id() ? 'text-emerald-100' : 'text-gray-500' }} mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Message Input - Fixed at bottom -->
            <div class="p-4 bg-white border-t">
                <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <button type="button" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </button>

                    <input type="text" 
                           name="content" 
                           placeholder="Écrivez votre message..." 
                           class="flex-1 px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <button type="button" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>

                    <button type="submit" class="bg-emerald-500 text-white p-2 rounded-full hover:bg-emerald-600">
                        <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    </script>
    @endpush
@endsection 
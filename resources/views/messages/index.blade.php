@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-[#f8f9fa]">
    <!-- Left Sidebar -->
    <div class="w-80 bg-white border-r flex flex-col">
        <!-- Chats Header -->
        <div class="p-4 border-b">
            <h1 class="text-xl font-semibold">Chats</h1>
        </div>

        <!-- Search -->
        <div class="p-4">
            <div class="relative">
                <input type="text" 
                       class="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 border-none focus:ring-2 focus:ring-[#6c5ce7]" 
                       placeholder="Search messages or users">
                <div class="absolute left-3 top-2.5">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="px-4 flex space-x-2 overflow-x-auto">
            @foreach($recentUsers as $user)
            <div class="flex flex-col items-center space-y-1 min-w-[60px]">
                <div class="relative">
                    <img src="{{ $user->profile_photo_url }}" 
                         alt="{{ $user->name }}"
                         class="w-12 h-12 rounded-full border-2 border-white">
                    <div class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-green-400 border-2 border-white"></div>
                </div>
                <span class="text-xs text-gray-600 truncate w-full text-center">{{ $user->name }}</span>
            </div>
            @endforeach
        </div>

        <!-- Recent Chats -->
        <div class="flex-1 overflow-y-auto mt-4">
            <h3 class="px-4 py-2 text-sm font-semibold text-gray-500">Recent</h3>
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->otherUser->first();
                @endphp
                <a href="{{ route('messages.show', ['conversation' => $conversation]) }}" 
                   class="flex items-center px-4 py-3 hover:bg-gray-50 {{ isset($currentConversation) && $currentConversation->id === $conversation->id ? 'bg-gray-50' : '' }}">
                    <div class="relative">
                        <img src="{{ $otherUser->profile_photo_url }}" 
                             alt="{{ $otherUser->name }}"
                             class="w-10 h-10 rounded-full">
                        <div class="absolute bottom-0 right-0 w-3 h-3 rounded-full {{ $otherUser->is_online ? 'bg-green-400' : 'bg-gray-400' }} border-2 border-white"></div>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $otherUser->name }}</p>
                            <p class="text-xs text-gray-500">{{ $conversation->lastMessage->created_at->format('H:i') }}</p>
                        </div>
                        <p class="text-sm text-gray-500 truncate">{{ $conversation->lastMessage->content }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col bg-white">
        @if(isset($currentConversation))
        <!-- Chat Header -->
        <div class="h-16 px-4 border-b flex items-center justify-between bg-white">
            <div class="flex items-center">
                <img src="{{ $currentConversation->otherUser->first()->profile_photo_url }}" 
                     alt="{{ $currentConversation->otherUser->first()->name }}"
                     class="w-10 h-10 rounded-full">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $currentConversation->otherUser->first()->name }}</p>
                    <p class="text-xs text-gray-500">{{ $currentConversation->otherUser->first()->is_online ? 'Online' : 'Offline' }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-[#6c5ce7]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-[#6c5ce7]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
                <button class="text-gray-500 hover:text-[#6c5ce7]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-[#f8f9fa]" id="messages-container">
            @foreach($messages as $message)
            <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                @if($message->user_id !== auth()->id())
                <img src="{{ $message->user->profile_photo_url }}" 
                     alt="{{ $message->user->name }}"
                     class="w-8 h-8 rounded-full mr-2">
                @endif
                <div class="{{ $message->user_id === auth()->id() ? 'bg-[#6c5ce7] text-white' : 'bg-white text-gray-900' }} rounded-lg px-4 py-2 max-w-md shadow-sm">
                    <p class="text-sm">{{ $message->content }}</p>
                    <p class="text-xs {{ $message->user_id === auth()->id() ? 'text-purple-200' : 'text-gray-500' }} mt-1">
                        {{ $message->created_at->format('H:i') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Message Input -->
        <div class="p-4 bg-white border-t">
            <form action="{{ route('messages.store', $currentConversation) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <button type="button" class="p-2 text-gray-500 hover:text-[#6c5ce7] rounded-full hover:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                </button>
                <input type="text" 
                       name="content"
                       class="flex-1 bg-[#f8f9fa] border-0 rounded-full px-4 py-2 focus:ring-2 focus:ring-[#6c5ce7]"
                       placeholder="Enter Message...">
                <button type="button" class="p-2 text-gray-500 hover:text-[#6c5ce7] rounded-full hover:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
                <button type="submit" class="p-2 text-white bg-[#6c5ce7] rounded-full hover:bg-[#5f4ed0]">
                    <svg class="h-5 w-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
        @else
        <div class="flex-1 flex items-center justify-center bg-[#f8f9fa]">
            <p class="text-gray-500">Select a conversation to start messaging</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Scroll to bottom of messages container
    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Auto-refresh messages
    setInterval(() => {
        if (typeof currentConversationId !== 'undefined') {
            fetch(`/messages/${currentConversationId}/refresh`)
                .then(response => response.json())
                .then(data => {
                    // Update messages
                });
        }
    }, 3000);
</script>
@endpush
@endsection

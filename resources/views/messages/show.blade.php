@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-white">
    <div class="flex-1 flex flex-col">
        <!-- Chat Header -->
        <div class="h-16 px-4 border-b flex items-center bg-white">
            <div class="flex items-center space-x-3">
                <a href="{{ route('messages.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-full bg-[#6c5ce7] bg-opacity-10 flex items-center justify-center">
                        <span class="text-[#6c5ce7] text-sm">{{ substr($other_user->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <h2 class="text-gray-800">{{ $other_user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $other_user->is_online ? 'En ligne' : 'Hors ligne' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto p-4" id="messages-container">
            <div class="flex flex-col space-y-3">
                @foreach($messages as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        @if($message->sender_id !== auth()->id())
                            <div class="flex-shrink-0 mr-2">
                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-600 text-sm">{{ substr($message->sender->name, 0, 1) }}</span>
                                </div>
                            </div>
                        @endif
                        <div>
                            <div class="{{ $message->sender_id === auth()->id() 
                                ? 'bg-[#6c5ce7] text-white rounded-[20px]' 
                                : 'bg-gray-100 text-gray-800 rounded-[20px]' }} 
                                px-4 py-2 max-w-[280px]">
                                <p class="text-[15px] leading-relaxed">{{ $message->content }}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right mr-1' : 'ml-1' }}">
                                {{ $message->created_at->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Message Input -->
        <div class="p-4 bg-white border-t">
            <form action="{{ route('messages.store.direct') }}" method="POST" class="flex items-center space-x-2">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $other_user->id }}">
                <div class="flex-1">
                    <input type="text" 
                           name="content"
                           class="w-full px-4 py-2 rounded-full bg-gray-100 border-0 focus:ring-1 focus:ring-[#6c5ce7]"
                           placeholder="Enter Message..."
                           autocomplete="off">
                </div>
                <button type="submit" 
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-[#6c5ce7] text-white hover:bg-[#5b4cdb]">
                    <svg class="h-5 w-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    
    // Scroll to bottom initially
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Auto-scroll on new messages
    const observer = new MutationObserver(() => {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });

    observer.observe(messagesContainer, {
        childList: true,
        subtree: true
    });

    // Focus input on load
    document.querySelector('input[name="content"]').focus();
});
</script>
@endpush
@endsection 
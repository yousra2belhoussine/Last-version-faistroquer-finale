@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="w-1/3 border-r bg-white shadow-lg">
            <!-- User Profile -->
            <div class="p-4 border-b bg-gradient-to-r from-[#157e74] to-[#279078]">
                <div class="flex items-center">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-12 w-12 rounded-full object-cover ring-2 ring-white/80 shadow-lg transform hover:scale-105 transition-all duration-300"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                    @else
                        <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center text-[#157e74] font-semibold ring-2 ring-white/80 shadow-lg transform hover:scale-105 transition-all duration-300">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h2 class="font-semibold text-white">{{ auth()->user()->name }}</h2>
                        <p class="text-sm text-white/80">En ligne</p>
                    </div>
                </div>
            </div>

            <!-- Conversations List -->
            <div class="flex-1 overflow-y-auto">
                @foreach($conversations as $conv)
                    @php
                        $otherParticipant = $conv->participants->where('id', '!=', auth()->id())->first();
                    @endphp
                    @if($otherParticipant)
                        <a href="{{ route('messages.show', $conv) }}" 
                           class="block p-4 hover:bg-[#35a79b]/5 transition-all duration-200 {{ request()->route('conversation') && request()->route('conversation')->id === $conv->id ? 'bg-[#35a79b]/10 border-l-4 border-[#157e74]' : '' }}">
                            <div class="flex items-center">
                                @if($otherParticipant->profile_photo_path)
                                    <img src="{{ asset('storage/' . $otherParticipant->profile_photo_path) }}" 
                                         alt="{{ $otherParticipant->name }}" 
                                         class="h-12 w-12 rounded-full object-cover ring-2 ring-[#35a79b]/20 shadow-md transform hover:scale-105 transition-all duration-300"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                @else
                                    <div class="h-12 w-12 rounded-full bg-[#157e74] flex items-center justify-center text-white font-semibold ring-2 ring-[#35a79b]/20 shadow-md transform hover:scale-105 transition-all duration-300">
                                        {{ substr($otherParticipant->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-[#157e74]">{{ $otherParticipant->name }}</h3>
                                        @if($conv->messages->isNotEmpty())
                                            <span class="text-xs text-[#6dbaaf]">{{ $conv->messages->first()->created_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                    @if($conv->messages->isNotEmpty())
                                        <p class="text-sm text-[#6dbaaf] truncate">{{ $conv->messages->first()->content }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col h-screen bg-gray-50">
            @if(isset($conversation) && $conversation->participants->isNotEmpty())
                @php
                    $otherParticipant = $conversation->participants->where('id', '!=', auth()->id())->first();
                @endphp
                @if($otherParticipant)
                    <!-- Chat Header -->
                    <div class="p-4 border-b flex items-center justify-between bg-white shadow-sm">
                        <div class="flex items-center">
                            @if($otherParticipant->profile_photo_path)
                                <img src="{{ asset('storage/' . $otherParticipant->profile_photo_path) }}" 
                                     alt="{{ $otherParticipant->name }}" 
                                     class="h-10 w-10 rounded-full object-cover ring-2 ring-[#35a79b]/20 shadow-md transform hover:scale-105 transition-all duration-300"
                                     onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                            @else
                                <div class="h-10 w-10 rounded-full bg-[#157e74] flex items-center justify-center text-white font-semibold ring-2 ring-[#35a79b]/20 shadow-md transform hover:scale-105 transition-all duration-300">
                                    {{ substr($otherParticipant->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="ml-4">
                                <h2 class="font-semibold text-[#157e74]">{{ $otherParticipant->name }}</h2>
                                <p class="text-sm text-[#6dbaaf]">En ligne</p>
                            </div>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                        @if(!isset($messages) || $messages->isEmpty())
                            <div class="flex flex-col items-center justify-center h-full text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-[#157e74] to-[#279078] rounded-full flex items-center justify-center mb-4 shadow-lg animate-pulse">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-[#157e74]">Aucun message</h3>
                                <p class="text-[#6dbaaf]">Commencez la conversation en envoyant un message</p>
                            </div>
                        @else
                            @foreach($messages as $message)
                                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} animate-fade-in">
                                    @if($message->sender_id !== auth()->id())
                                        <div class="flex-shrink-0 mr-3">
                                            @if($message->sender && $message->sender->profile_photo_path)
                                                <img src="{{ asset('storage/' . $message->sender->profile_photo_path) }}" 
                                                     alt="{{ $message->sender->name }}" 
                                                     class="h-8 w-8 rounded-full object-cover ring-2 ring-[#35a79b]/20 shadow-md"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-[#157e74] flex items-center justify-center text-white text-sm font-semibold ring-2 ring-[#35a79b]/20 shadow-md">
                                                    {{ $message->sender ? substr($message->sender->name, 0, 1) : '?' }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="{{ $message->sender_id === auth()->id() ? 'bg-gradient-to-r from-[#157e74] to-[#279078] text-white' : 'bg-white text-gray-800' }} rounded-2xl px-4 py-2 max-w-[70%] shadow-md hover:shadow-lg transition-shadow duration-200">
                                        <p class="text-sm">{{ $message->content }}</p>
                                        <span class="text-xs {{ $message->sender_id === auth()->id() ? 'text-white/70' : 'text-gray-500' }} block mt-1">
                                            {{ $message->created_at->format('H:i') }}
                                        </span>
                                    </div>
                                    @if($message->sender_id === auth()->id())
                                        <div class="flex-shrink-0 ml-3">
                                            @if(auth()->user()->profile_photo_path)
                                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                                     alt="{{ auth()->user()->name }}" 
                                                     class="h-8 w-8 rounded-full object-cover ring-2 ring-[#35a79b]/20 shadow-md"
                                                     onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-[#157e74] flex items-center justify-center text-white text-sm font-semibold ring-2 ring-[#35a79b]/20 shadow-md">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 bg-white border-t shadow-lg">
                        <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex items-center space-x-4">
                            @csrf
                            <input type="text" 
                                   name="content" 
                                   placeholder="Écrivez votre message..." 
                                   class="flex-1 px-4 py-2 rounded-full border-[#a3cca8] focus:ring-2 focus:ring-[#157e74] focus:border-[#157e74] shadow-sm hover:shadow-md transition-shadow duration-200"
                                   required>

                            <button type="submit" class="bg-gradient-to-r from-[#157e74] to-[#279078] text-white p-3 rounded-full hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <!-- Welcome Screen -->
                <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-[#157e74]/5 to-[#279078]/5">
                    <div class="text-center transform hover:scale-105 transition-transform duration-300">
                        <div class="w-24 h-24 bg-gradient-to-br from-[#157e74] to-[#279078] rounded-full mx-auto flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-[#2c8a7e]">Bienvenue dans vos messages</h2>
                        <p class="text-[#35a79b]/70 mt-2">Sélectionnez une conversation pour commencer à discuter</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #messages-container::-webkit-scrollbar {
            width: 6px;
        }

        #messages-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #messages-container::-webkit-scrollbar-thumb {
            background: #a3cca8;
            border-radius: 3px;
        }

        #messages-container::-webkit-scrollbar-thumb:hover {
            background: #157e74;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Scroll to bottom of messages container
        const messagesContainer = document.getElementById('messages-container');
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Auto-scroll on new message
        const messageForm = document.querySelector('form');
        if (messageForm) {
            messageForm.addEventListener('submit', () => {
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 100);
            });
        }
    </script>
    @endpush
@endsection 
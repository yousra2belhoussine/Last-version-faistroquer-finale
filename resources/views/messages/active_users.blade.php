@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Utilisateurs actifs dans les messages</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeUsers as $user)
                        <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-center space-x-4">
                                @if($user->profile_photo_url)
                                    <img src="{{ $user->profile_photo_url }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-12 h-12 rounded-full">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <div class="flex items-center justify-between text-sm text-gray-600">
                                    <span>Messages envoyés :</span>
                                    <span class="font-semibold">{{ $user->messages_count }}</span>
                                </div>
                                
                                @if($user->messages->first())
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Dernier message :</p>
                                        <p class="text-sm text-gray-700 mt-1">
                                            {{ \Str::limit($user->messages->first()->content, 50) }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $user->messages->first()->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mt-4 pt-4 border-t">
                                <a href="{{ route('messages.show.direct', $user) }}" 
                                   class="inline-flex items-center justify-center w-full px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Envoyer un message
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
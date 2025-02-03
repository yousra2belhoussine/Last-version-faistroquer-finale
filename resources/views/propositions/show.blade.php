@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('propositions.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Back to Propositions') }}
                    </a>
                </div>

                <!-- Proposition Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Exchange Proposition for') }}: {{ $proposition->ad->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-4">
                                <i class="fas fa-user mr-1"></i>
                                {{ __('Proposed by') }}: {{ $proposition->user->name }}
                            </span>
                            <span class="mr-4">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $proposition->created_at->diffForHumans() }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($proposition->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($proposition->status === 'accepted') bg-green-100 text-green-800
                                @elseif($proposition->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($proposition->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        @if($proposition->isPending() && Auth::id() === $proposition->ad->user_id)
                            <form action="{{ route('propositions.accept', $proposition) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    {{ __('Accept') }}
                                </button>
                            </form>

                            <form action="{{ route('propositions.reject', $proposition) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    {{ __('Reject') }}
                                </button>
                            </form>
                        @endif

                        @if(($proposition->isPending() || $proposition->isAccepted()) && 
                            (Auth::id() === $proposition->user_id || Auth::id() === $proposition->ad->user_id))
                            <form action="{{ route('propositions.cancel', $proposition) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    {{ __('Cancel') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Proposition Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2">
                        <!-- Offer Details -->
                        <div class="bg-white rounded-lg shadow p-6 border border-gray-200 mb-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Offer Details') }}</h2>
                            <div class="prose max-w-none">
                                <p class="text-gray-700 whitespace-pre-line">{{ $proposition->offer }}</p>
                            </div>

                            @if($proposition->message)
                                <div class="mt-6">
                                    <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Additional Message') }}</h3>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $proposition->message }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Exchange Details -->
                        @if($proposition->isAccepted())
                            <div class="bg-white rounded-lg shadow p-6 border border-gray-200 mb-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-medium text-gray-900">{{ __('Exchange Details') }}</h2>
                                    @if(Auth::id() === $proposition->ad->user_id && !$proposition->isCompleted())
                                        <form action="{{ route('propositions.complete', $proposition) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                {{ __('Mark as Completed') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if($proposition->online_exchange)
                                    <div class="bg-blue-50 rounded-md p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800">{{ __('Online Exchange') }}</h3>
                                                <p class="mt-2 text-sm text-blue-700">
                                                    {{ __('This exchange will be conducted online. Please coordinate with the other party to arrange the details.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-md p-4">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">{{ __('Meeting Location') }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $proposition->meeting_location }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">{{ __('Meeting Date') }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900">{{ $proposition->meeting_date->format('F j, Y g:i A') }}</dd>
                                            </div>
                                        </dl>

                                        @if($proposition->isAccepted() && !$proposition->isCompleted())
                                            <div class="mt-4">
                                                <button type="button" onclick="showUpdateMeetingModal()" class="text-sm text-indigo-600 hover:text-indigo-500">
                                                    {{ __('Update Meeting Details') }}
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Messages -->
                        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Messages') }}</h2>
                            <div id="messages" class="space-y-4 mb-4 h-96 overflow-y-auto">
                                <!-- Messages will be loaded here -->
                            </div>

                            <form id="message-form" class="mt-4" action="{{ route('messages.store.proposition', $proposition) }}" method="POST">
                                <div class="flex items-start space-x-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="relative">
                                            <textarea
                                                id="message-content"
                                                name="content"
                                                rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                placeholder="{{ __('Write a message...') }}"
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Send') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="md:col-span-1">
                        <!-- Ad Details -->
                        <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">{{ __('Ad Details') }}</h2>
                            <div class="space-y-4">
                                @if($proposition->ad->images->isNotEmpty())

                                    <img src="{{ asset('storage/'.$proposition->ad->images->first()->image_path) }}" alt="{{ $proposition->ad->title }}" class="w-full h-48 object-cover rounded-lg">
                                    @endif

                                <h3 class="text-base font-medium text-gray-900">{{ $proposition->ad->title }}</h3>
                                <p class="text-sm text-gray-600">{{ Str::limit($proposition->ad->description, 150) }}</p>

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $proposition->ad->location }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $proposition->ad->type === 'goods' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($proposition->ad->type) }}
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('ads.show', $proposition->ad) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        {{ __('View Ad Details') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Meeting Modal -->
<div id="update-meeting-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('propositions.update-meeting', $proposition) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                        {{ __('Update Meeting Details') }}
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="meeting_location" class="block text-sm font-medium text-gray-700">
                                {{ __('Meeting Location') }}
                            </label>
                            <input type="text" name="meeting_location" id="meeting_location" value="{{ $proposition->meeting_location }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="meeting_date" class="block text-sm font-medium text-gray-700">
                                {{ __('Meeting Date and Time') }}
                            </label>
                            <input type="datetime-local" name="meeting_date" id="meeting_date" value="{{ $proposition->meeting_date ? $proposition->meeting_date->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Update Meeting') }}
                    </button>
                    <button type="button" onclick="hideUpdateMeetingModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showUpdateMeetingModal() {
        document.getElementById('update-meeting-modal').classList.remove('hidden');
    }

    function hideUpdateMeetingModal() {
        document.getElementById('update-meeting-modal').classList.add('hidden');
    }

    // Messaging functionality
    const messagesContainer = document.getElementById('messages');
    const messageForm = document.getElementById('message-form');
    const messageContent = document.getElementById('message-content');
    let lastMessageId = 0;

    function loadMessages() {
        fetch(`/propositions/{{ $proposition->id }}/messages`)
            .then(response => response.json())
            .then(data => {
                const messages = data.messages;
                let html = '';

                messages.forEach(message => {
                    html += `
                        <div class="flex ${message.is_from_current_user ? 'justify-end' : 'justify-start'}">
                            <div class="inline-block max-w-lg ${message.is_from_current_user ? 'bg-indigo-100' : 'bg-gray-100'} rounded-lg px-4 py-2">
                                <div class="flex items-center">
                                    <span class="font-medium text-sm text-gray-900">${message.user.name}</span>
                                    <span class="ml-2 text-xs text-gray-500">${message.created_at}</span>
                                </div>
                                <p class="text-sm text-gray-800 mt-1">${message.content}</p>
                            </div>
                        </div>
                    `;
                    lastMessageId = Math.max(lastMessageId, message.id);
                });

                messagesContainer.innerHTML = html;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
    }

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const content = messageContent.value.trim();
        if (!content) return;

        fetch(`/propositions/{{ $proposition->id }}/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageContent.value = '';
                loadMessages();
            }
        });
    });

    // Load messages initially and set up polling
    loadMessages();
    setInterval(loadMessages, 5000);
</script>
@endpush
@endsection 
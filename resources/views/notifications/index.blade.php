@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
                <p class="text-gray-500">Restez informé des activités importantes</p>
            </div>
            <button onclick="markAllAsRead()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-indigo-100 hover:bg-indigo-200">
                Tout marquer comme lu
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Liste des notifications -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="divide-y divide-gray-200">
                    @forelse($notifications as $notification)
                        <div class="p-6 {{ $notification->read_at ? 'bg-white' : 'bg-indigo-50' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @switch($notification->type)
                                        @case('App\Notifications\NewMessage')
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                                </svg>
                                            </div>
                                            @break
                                        @case('App\Notifications\NewProposition')
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            @break
                                        @default
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                </svg>
                                            </div>
                                    @endswitch
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $notification->data['title'] }}
                                        </p>
                                        <span class="text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    @if(isset($notification->data['action']))
                                        <div class="mt-3">
                                            <a href="{{ $notification->data['action']['url'] }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                                {{ $notification->data['action']['label'] }}
                                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                @unless($notification->read_at)
                                    <div class="ml-4">
                                        <button onclick="markAsRead('{{ $notification->id }}')" class="text-sm text-gray-500 hover:text-gray-700">
                                            Marquer comme lu
                                        </button>
                                    </div>
                                @endunless
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500">Aucune notification pour le moment</p>
                        </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Préférences de notification -->
        <div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Préférences de notification</h2>
                <form action="{{ route('notifications.settings.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="message_notifications" id="message_notifications"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ $user->notification_preferences['message_notifications'] ?? true ? 'checked' : '' }}>
                                <label for="message_notifications" class="ml-2 block text-sm text-gray-900">
                                    Messages reçus
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="proposition_notifications" id="proposition_notifications"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ $user->notification_preferences['proposition_notifications'] ?? true ? 'checked' : '' }}>
                                <label for="proposition_notifications" class="ml-2 block text-sm text-gray-900">
                                    Nouvelles propositions
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" name="admin_notifications" id="admin_notifications"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ $user->notification_preferences['admin_notifications'] ?? true ? 'checked' : '' }}>
                                <label for="admin_notifications" class="ml-2 block text-sm text-gray-900">
                                    Notifications administratives
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Enregistrer les préférences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
</script>
@endpush
@endsection 
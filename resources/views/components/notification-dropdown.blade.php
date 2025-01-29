<div x-data="{ open: false, notifications: [], unreadCount: 0 }" @click.away="open = false" class="relative">
    <!-- Notification Button -->
    <button @click="open = !open" class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="sr-only">{{ __('View notifications') }}</span>
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <!-- Unread Count Badge -->
        <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
    </button>

    <!-- Notification Panel -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="notifications-menu">
        <div class="py-1" role="none">
            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="font-medium">{{ __('Notifications') }}</h3>
                    <button x-show="notifications.length > 0" @click="markAllAsRead" class="text-indigo-600 hover:text-indigo-900 text-xs">
                        {{ __('Mark all as read') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <div class="px-4 py-6 text-sm text-gray-500 text-center">
                    {{ __('No notifications') }}
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="relative px-4 py-3 hover:bg-gray-50 transition-colors duration-200 ease-in-out" :class="{ 'bg-blue-50': !notification.read_at }">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-0.5">
                            <template x-if="notification.type.includes('NewMessage')">
                                <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </template>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900" x-text="notification.data.sender_name"></p>
                            <p class="mt-1 text-sm text-gray-500" x-text="notification.data.content"></p>
                            <div class="mt-2 text-xs text-gray-400 flex justify-between items-center">
                                <span x-text="formatDate(notification.created_at)"></span>
                                <button @click="markAsRead(notification.id)" x-show="!notification.read_at" class="text-indigo-600 hover:text-indigo-900">
                                    {{ __('Mark as read') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div x-show="notifications.length > 0" class="py-1" role="none">
            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-indigo-600 hover:text-indigo-900">
                {{ __('View all notifications') }}
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function initNotifications() {
        return {
            open: false,
            notifications: [],
            unreadCount: 0,

            init() {
                this.loadNotifications();
                this.setupPusher();
                setInterval(() => this.loadNotifications(), 30000);
            },

            loadNotifications() {
                fetch('/notifications/recent')
                    .then(response => response.json())
                    .then(data => {
                        this.notifications = data.notifications;
                        this.unreadCount = data.unread_count;
                    });
            },

            markAsRead(id) {
                fetch(`/notifications/${id}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(() => {
                    this.loadNotifications();
                });
            },

            markAllAsRead() {
                fetch('/notifications/mark-all-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(() => {
                    this.loadNotifications();
                });
            },

            formatDate(date) {
                return new Date(date).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            },

            setupPusher() {
                // If you're using Pusher for real-time notifications
                if (typeof Echo !== 'undefined') {
                    Echo.private(`App.Models.User.{{ auth()->id() }}`)
                        .notification((notification) => {
                            this.notifications.unshift(notification);
                            this.unreadCount++;
                        });
                }
            }
        }
    }
</script>
@endpush 
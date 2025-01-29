<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Account Settings</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Manage your account preferences and notification settings.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="{{ route('settings.update') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <!-- Profile Information -->
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Profile Information</h4>
                                            <p class="mt-1 text-sm text-gray-500">Update your profile information and email address.</p>
                                        </div>

                                        <!-- Name -->
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <div class="mt-1">
                                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <div class="mt-1">
                                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            @error('email')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Notification Settings -->
                                    <div class="px-4 py-5 bg-gray-50 space-y-6 sm:p-6">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Notification Settings</h4>
                                            <p class="mt-1 text-sm text-gray-500">Choose how you want to receive notifications.</p>
                                        </div>

                                        <div class="space-y-4">
                                            <!-- Email Notifications -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="email_notifications" id="email_notifications" value="1" {{ old('email_notifications', auth()->user()->settings->email_notifications ?? true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="email_notifications" class="font-medium text-gray-700">Email Notifications</label>
                                                    <p class="text-gray-500">Receive email notifications about new messages, transactions, and updates.</p>
                                                </div>
                                            </div>

                                            <!-- Browser Notifications -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="browser_notifications" id="browser_notifications" value="1" {{ old('browser_notifications', auth()->user()->settings->browser_notifications ?? true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="browser_notifications" class="font-medium text-gray-700">Browser Notifications</label>
                                                    <p class="text-gray-500">Receive browser notifications when you're online.</p>
                                                </div>
                                            </div>

                                            <!-- Marketing Emails -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="marketing_emails" id="marketing_emails" value="1" {{ old('marketing_emails', auth()->user()->settings->marketing_emails ?? false) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="marketing_emails" class="font-medium text-gray-700">Marketing Emails</label>
                                                    <p class="text-gray-500">Receive emails about new features, tips, and promotions.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Privacy Settings -->
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Privacy Settings</h4>
                                            <p class="mt-1 text-sm text-gray-500">Control your privacy preferences.</p>
                                        </div>

                                        <div class="space-y-4">
                                            <!-- Profile Visibility -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="public_profile" id="public_profile" value="1" {{ old('public_profile', auth()->user()->settings->public_profile ?? true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="public_profile" class="font-medium text-gray-700">Public Profile</label>
                                                    <p class="text-gray-500">Make your profile visible to other users.</p>
                                                </div>
                                            </div>

                                            <!-- Show Online Status -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="show_online_status" id="show_online_status" value="1" {{ old('show_online_status', auth()->user()->settings->show_online_status ?? true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="show_online_status" class="font-medium text-gray-700">Show Online Status</label>
                                                    <p class="text-gray-500">Let other users see when you're online.</p>
                                                </div>
                                            </div>

                                            <!-- Show Location -->
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input type="checkbox" name="show_location" id="show_location" value="1" {{ old('show_location', auth()->user()->settings->show_location ?? true) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="show_location" class="font-medium text-gray-700">Show Location</label>
                                                    <p class="text-gray-500">Display your general location on your profile.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Language and Region -->
                                    <div class="px-4 py-5 bg-gray-50 space-y-6 sm:p-6">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Language and Region</h4>
                                            <p class="mt-1 text-sm text-gray-500">Set your preferred language and region settings.</p>
                                        </div>

                                        <!-- Language -->
                                        <div>
                                            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                                            <div class="mt-1">
                                                <select id="language" name="language" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                    <option value="en" {{ old('language', auth()->user()->settings->language ?? 'en') == 'en' ? 'selected' : '' }}>English</option>
                                                    <option value="fr" {{ old('language', auth()->user()->settings->language ?? 'en') == 'fr' ? 'selected' : '' }}>Français</option>
                                                    <option value="es" {{ old('language', auth()->user()->settings->language ?? 'en') == 'es' ? 'selected' : '' }}>Español</option>
                                                    <option value="de" {{ old('language', auth()->user()->settings->language ?? 'en') == 'de' ? 'selected' : '' }}>Deutsch</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Timezone -->
                                        <div>
                                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                            <div class="mt-1">
                                                <select id="timezone" name="timezone" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                    <option value="UTC" {{ old('timezone', auth()->user()->settings->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                    <option value="Europe/Paris" {{ old('timezone', auth()->user()->settings->timezone ?? 'UTC') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                                                    <option value="Europe/London" {{ old('timezone', auth()->user()->settings->timezone ?? 'UTC') == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                                    <option value="America/New_York" {{ old('timezone', auth()->user()->settings->timezone ?? 'UTC') == 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mt-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-red-600">Delete Account</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Permanently delete your account and all associated data.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="space-y-6">
                                    <p class="text-sm text-gray-500">
                                        Once you delete your account, all of your data will be permanently removed. This action cannot be undone.
                                    </p>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" id="confirm_delete" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="confirm_delete" class="font-medium text-gray-700">I understand that this action cannot be undone</label>
                                        </div>
                                    </div>

                                    <div>
                                        <button type="button" id="delete_account" disabled class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 opacity-50 cursor-not-allowed">
                                            Delete Account
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteCheckbox = document.getElementById('confirm_delete');
            const deleteAccountButton = document.getElementById('delete_account');

            confirmDeleteCheckbox.addEventListener('change', function() {
                deleteAccountButton.disabled = !this.checked;
                if (this.checked) {
                    deleteAccountButton.classList.remove('opacity-50', 'cursor-not-allowed');
                } else {
                    deleteAccountButton.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });

            deleteAccountButton.addEventListener('click', function() {
                if (confirmDeleteCheckbox.checked) {
                    if (confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.')) {
                        // Submit delete account form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('profile.destroy') }}';
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        const method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'DELETE';
                        form.appendChild(method);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 
                <!-- Badges -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Badges') }}</h3>
                    
                    <div class="bg-white rounded-lg shadow p-4">
                        @if($user->badges->isEmpty())
                            <p class="text-gray-500 text-center">{{ __('Cet utilisateur n\'a pas encore de badges.') }}</p>
                        @else
                            <div class="flex flex-wrap gap-4">
                                @foreach($user->badges->sortByDesc('awarded_at')->take(6) as $badge)
                                    <x-badge :badge="$badge" :showName="true" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div> 
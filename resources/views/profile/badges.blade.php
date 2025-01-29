@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-semibold mb-6">{{ __('Mes badges') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Exemple de badges -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-[#157e74] text-white rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium">{{ __('Premier échange') }}</h3>
                                <p class="text-sm text-gray-500">{{ __('Vous avez réalisé votre premier échange') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium">{{ __('Ambassadeur') }}</h3>
                                <p class="text-sm text-gray-500">{{ __('Parrainez 5 nouveaux membres') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-gray-200 text-gray-400 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium">{{ __('Super échangeur') }}</h3>
                                <p class="text-sm text-gray-500">{{ __('Réalisez 10 échanges réussis') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium mb-4">{{ __('Comment obtenir plus de badges ?') }}</h3>
                    <ul class="list-disc list-inside text-gray-600 space-y-2">
                        <li>{{ __('Complétez votre profil à 100%') }}</li>
                        <li>{{ __('Participez activement aux échanges') }}</li>
                        <li>{{ __('Recevez des avis positifs') }}</li>
                        <li>{{ __('Parrainez de nouveaux membres') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
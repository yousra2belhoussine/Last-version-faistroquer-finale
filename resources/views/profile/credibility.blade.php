@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Score de Crédibilité</h1>
        <p class="text-gray-500">Votre score de crédibilité reflète votre fiabilité en tant que membre de la communauté</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Score et statistiques -->
        <div class="md:col-span-2">
            <!-- Score principal -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Score actuel</h2>
                        <p class="text-sm text-gray-500 mt-1">Mis à jour quotidiennement</p>
                    </div>
                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-3xl font-bold text-indigo-600">{{ $credibilityScore }}</span>
                    </div>
                </div>

                <!-- Facteurs de score -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-4">Facteurs influençant votre score</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm text-gray-600">Transactions réussies</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $transactions->where('status', 'completed')->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <span class="text-sm text-gray-600">Avis positifs reçus</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $positiveReviews }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                                <span class="text-sm text-gray-600">Badges obtenus</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $badges->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activité récente -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Activité récente</h2>
                @if($transactions->count() > 0)
                    <div class="space-y-6">
                        @foreach($transactions as $transaction)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        @if($transaction->status === 'completed')
                                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @elseif($transaction->status === 'cancelled')
                                            <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">{{ $transaction->ad->title }}</h3>
                                        <span class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Status : 
                                        <span class="font-medium
                                            @if($transaction->status === 'completed') text-green-600
                                            @elseif($transaction->status === 'cancelled') text-red-600
                                            @else text-yellow-600
                                            @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune activité récente</p>
                @endif
            </div>
        </div>

        <!-- Conseils et badges -->
        <div>
            <!-- Comment améliorer -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Comment améliorer votre score</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Complétez vos transactions avec succès</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Recevez des avis positifs des autres membres</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Gagnez des badges en participant activement</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-indigo-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Maintenez une communication régulière</span>
                    </li>
                </ul>
            </div>

            <!-- Prochains badges -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Prochains badges à obtenir</h2>
                @if($badges->count() < 10)
                    <div class="space-y-4">
                        @foreach($badges->take(3) as $badge)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-lg text-indigo-600">{{ $badge->icon }}</span>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $badge->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $badge->requirements }}</p>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('profile.badges') }}" class="block text-center text-sm text-indigo-600 hover:text-indigo-500">
                            Voir tous les badges disponibles
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center">Félicitations ! Vous avez obtenu tous les badges disponibles.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
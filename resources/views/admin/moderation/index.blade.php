@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold text-gray-900">Modération</h1>
                <p class="mt-2 text-sm text-gray-700">Gestion des signalements et des litiges</p>
            </div>
        </div>

        <!-- Statistiques de modération -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Signalements en attente -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Signalements en attente</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $statistics['pending_reports'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Litiges actifs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Litiges actifs</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $statistics['active_disputes'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Utilisateurs signalés -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Utilisateurs signalés</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $statistics['reported_users'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Annonces signalées -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Annonces signalées</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $statistics['reported_ads'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.moderation.index') }}" method="GET" class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                    <div class="w-full sm:max-w-xs">
                        <label for="type" class="sr-only">Type</label>
                        <select id="type" name="type" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Tous les types</option>
                            <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>Utilisateurs</option>
                            <option value="ad" {{ request('type') === 'ad' ? 'selected' : '' }}>Annonces</option>
                            <option value="message" {{ request('type') === 'message' ? 'selected' : '' }}>Messages</option>
                        </select>
                    </div>
                    <div class="w-full sm:max-w-xs">
                        <label for="status" class="sr-only">Statut</label>
                        <select id="status" name="status" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Résolu</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Filtrer
                        </button>
                        @if(request()->hasAny(['type', 'status']))
                            <a href="{{ route('admin.moderation.index') }}" class="ml-3 text-sm text-gray-500 hover:text-gray-700">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des signalements -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Signalé par
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Raison
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $report->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $report->reportable_type === 'App\\Models\\User' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $report->reportable_type === 'App\\Models\\Ad' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $report->reportable_type === 'App\\Models\\Message' ? 'bg-green-100 text-green-800' : '' }}">
                                        {{ $report->reportable_type === 'App\\Models\\User' ? 'Utilisateur' : '' }}
                                        {{ $report->reportable_type === 'App\\Models\\Ad' ? 'Annonce' : '' }}
                                        {{ $report->reportable_type === 'App\\Models\\Message' ? 'Message' : '' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $report->reporter->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $report->reporter->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $report->reason }}</div>
                                    @if($report->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($report->description, 100) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match($report->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'in_progress' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $statusText = match($report->status) {
                                            'pending' => 'En attente',
                                            'in_progress' => 'En cours',
                                            'resolved' => 'Résolu',
                                            'rejected' => 'Rejeté',
                                            default => 'Inconnu'
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.moderation.show', $report) }}" class="text-indigo-600 hover:text-indigo-900">Détails</a>
                                    @if($report->status === 'pending')
                                        <form action="{{ route('admin.moderation.take', $report) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                Prendre en charge
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Aucun signalement trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($reports->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
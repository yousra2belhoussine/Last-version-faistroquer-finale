@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold text-gray-900">Gestion des concours</h1>
                <p class="mt-2 text-sm text-gray-700">Liste des concours et leurs participants</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('admin.contests.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    Créer un concours
                </a>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="p-4 sm:p-6">
                <form action="{{ route('admin.contests.index') }}" method="GET" class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-4">
                    <div class="w-full sm:max-w-xs">
                        <label for="search" class="sr-only">Rechercher</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Rechercher un concours...">
                        </div>
                    </div>
                    <div class="w-full sm:max-w-xs">
                        <label for="status" class="sr-only">Statut</label>
                        <select id="status" name="status" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>À venir</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>En cours</option>
                            <option value="ended" {{ request('status') === 'ended' ? 'selected' : '' }}>Terminé</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Filtrer
                        </button>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.contests.index') }}" class="ml-3 text-sm text-gray-500 hover:text-gray-700">
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des concours -->
        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Concours
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Période
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Participants
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
                        @forelse($contests as $contest)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($contest->image)
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded object-cover" src="{{ Storage::url($contest->image) }}" alt="{{ $contest->title }}">
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $contest->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ Str::limit($contest->description, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        Du {{ $contest->start_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Au {{ $contest->end_date->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $contest->participants_count }} participants</div>
                                    <div class="text-sm text-gray-500">
                                        <a href="{{ route('admin.contests.participants.index', $contest) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Voir les participants
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match($contest->status) {
                                            'upcoming' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'ended' => 'bg-gray-100 text-gray-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $statusText = match($contest->status) {
                                            'upcoming' => 'À venir',
                                            'active' => 'En cours',
                                            'ended' => 'Terminé',
                                            default => 'Inconnu'
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.contests.edit', $contest) }}" class="text-indigo-600 hover:text-indigo-900">Modifier</a>
                                    @if($contest->status === 'ended')
                                        <a href="{{ route('admin.contests.winners', $contest) }}" class="ml-2 text-green-600 hover:text-green-900">Gagnants</a>
                                    @endif
                                    <form action="{{ route('admin.contests.destroy', $contest) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce concours ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Aucun concours trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($contests->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $contests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
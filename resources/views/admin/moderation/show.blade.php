@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-3xl font-semibold text-gray-900">Détails du signalement</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Signalement #{{ $report->id }} - Créé le {{ $report->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <a href="{{ route('admin.moderation.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informations du signalement</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $report->reportable_type === 'App\\Models\\User' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $report->reportable_type === 'App\\Models\\Ad' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $report->reportable_type === 'App\\Models\\Message' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $report->reportable_type === 'App\\Models\\User' ? 'Utilisateur' : '' }}
                                {{ $report->reportable_type === 'App\\Models\\Ad' ? 'Annonce' : '' }}
                                {{ $report->reportable_type === 'App\\Models\\Message' ? 'Message' : '' }}
                            </span>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Statut</dt>
                        <dd class="mt-1 text-sm text-gray-900">
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
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Signalé par</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="flex items-center">
                                @if($report->reporter->avatar)
                                    <img class="h-8 w-8 rounded-full" src="{{ Storage::url($report->reporter->avatar) }}" alt="{{ $report->reporter->name }}">
                                @endif
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">{{ $report->reporter->name }}</div>
                                    <div class="text-gray-500">{{ $report->reporter->email }}</div>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Modérateur assigné</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($report->moderator)
                                <div class="flex items-center">
                                    @if($report->moderator->avatar)
                                        <img class="h-8 w-8 rounded-full" src="{{ Storage::url($report->moderator->avatar) }}" alt="{{ $report->moderator->name }}">
                                    @endif
                                    <div class="ml-3">
                                        <div class="font-medium text-gray-900">{{ $report->moderator->name }}</div>
                                        <div class="text-gray-500">{{ $report->moderator->email }}</div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-500">Non assigné</span>
                            @endif
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Raison</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $report->reason }}</dd>
                    </div>

                    @if($report->description)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Description</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $report->description }}</dd>
                        </div>
                    @endif

                    <!-- Contenu signalé -->
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Contenu signalé</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <div class="border border-gray-200 rounded-lg p-4">
                                @if($report->reportable_type === 'App\\Models\\User')
                                    <!-- Utilisateur signalé -->
                                    <div class="flex items-center">
                                        @if($report->reportable->avatar)
                                            <img class="h-12 w-12 rounded-full" src="{{ Storage::url($report->reportable->avatar) }}" alt="{{ $report->reportable->name }}">
                                        @endif
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $report->reportable->name }}</div>
                                            <div class="text-gray-500">{{ $report->reportable->email }}</div>
                                            <div class="text-gray-500">Membre depuis {{ $report->reportable->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                @elseif($report->reportable_type === 'App\\Models\\Ad')
                                    <!-- Annonce signalée -->
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $report->reportable->title }}</div>
                                        <div class="text-gray-500">{{ Str::limit($report->reportable->description, 200) }}</div>
                                        <div class="mt-2">
                                            <a href="{{ route('ads.show', $report->reportable) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                                Voir l'annonce
                                            </a>
                                        </div>
                                    </div>
                                @elseif($report->reportable_type === 'App\\Models\\Message')
                                    <!-- Message signalé -->
                                    <div>
                                        <div class="text-gray-500">De: {{ $report->reportable->sender->name }}</div>
                                        <div class="text-gray-500">À: {{ $report->reportable->recipient->name }}</div>
                                        <div class="mt-2 text-gray-900">{{ $report->reportable->content }}</div>
                                    </div>
                                @endif
                            </div>
                        </dd>
                    </div>

                    <!-- Notes de modération -->
                    @if($report->moderation_notes)
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Notes de modération</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="space-y-4">
                                    @foreach($report->moderation_notes as $note)
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="flex items-start">
                                                @if($note->moderator->avatar)
                                                    <img class="h-8 w-8 rounded-full" src="{{ Storage::url($note->moderator->avatar) }}" alt="{{ $note->moderator->name }}">
                                                @endif
                                                <div class="ml-3 flex-1">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $note->moderator->name }}
                                                        <span class="text-gray-500">- {{ $note->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                    <div class="mt-1 text-sm text-gray-700">
                                                        {{ $note->content }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Actions de modération -->
        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Actions</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                @if($report->status === 'pending')
                    <form action="{{ route('admin.moderation.take', $report) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Prendre en charge
                        </button>
                    </form>
                @endif

                @if($report->status === 'in_progress')
                    <div class="space-x-4">
                        <form action="{{ route('admin.moderation.resolve', $report) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Marquer comme résolu
                            </button>
                        </form>

                        <form action="{{ route('admin.moderation.reject', $report) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Rejeter
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Formulaire d'ajout de note -->
                <div class="mt-6">
                    <form action="{{ route('admin.moderation.notes.store', $report) }}" method="POST">
                        @csrf
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700">Ajouter une note</label>
                            <div class="mt-1">
                                <textarea id="note" name="content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Votre note de modération..."></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Ajouter la note
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Actions spécifiques selon le type -->
                @if($report->reportable_type === 'App\\Models\\User')
                    <div class="mt-6 space-x-4">
                        <form action="{{ route('admin.users.ban', $report->reportable) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Bannir l'utilisateur
                            </button>
                        </form>

                        <form action="{{ route('admin.users.warn', $report->reportable) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Envoyer un avertissement
                            </button>
                        </form>
                    </div>
                @elseif($report->reportable_type === 'App\\Models\\Ad')
                    <div class="mt-6 space-x-4">
                        <form action="{{ route('admin.ads.hide', $report->reportable) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                Masquer l'annonce
                            </button>
                        </form>

                        <form action="{{ route('admin.ads.delete', $report->reportable) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Supprimer l'annonce
                            </button>
                        </form>
                    </div>
                @elseif($report->reportable_type === 'App\\Models\\Message')
                    <div class="mt-6">
                        <form action="{{ route('admin.messages.delete', $report->reportable) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Supprimer le message
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
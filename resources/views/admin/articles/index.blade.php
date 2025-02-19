@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Gestion des articles</h2>

                <!-- Filtres -->
                <div class="mb-6">
                    <div class="flex gap-4">
                        <a href="{{ route('admin.articles.index', ['status' => 'pending']) }}" 
                           class="inline-flex items-center px-4 py-2 rounded-md {{ request('status') === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700' }} hover:bg-gray-200">
                            En attente
                            <span class="ml-2 text-xs bg-white px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                        </a>
                        <a href="{{ route('admin.articles.index', ['status' => 'approved']) }}"
                           class="inline-flex items-center px-4 py-2 rounded-md {{ request('status') === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }} hover:bg-gray-200">
                            Validés
                            <span class="ml-2 text-xs bg-white px-2 py-1 rounded-full">{{ $approvedCount }}</span>
                        </a>
                        <a href="{{ route('admin.articles.index', ['status' => 'rejected']) }}"
                           class="inline-flex items-center px-4 py-2 rounded-md {{ request('status') === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700' }} hover:bg-gray-200">
                            Refusés
                            <span class="ml-2 text-xs bg-white px-2 py-1 rounded-full">{{ $rejectedCount }}</span>
                        </a>
                    </div>
                </div>

                <!-- Liste des articles -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Article
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Auteur
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($articles as $article)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($article->images->isNotEmpty())
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ $article->images->first()->url }}" 
                                                     alt="">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $article->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $article->category->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $article->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $article->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $article->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                           ($article->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                           'bg-yellow-100 text-yellow-800') }}">
                                        {{ $article->status === 'approved' ? 'Validé' : 
                                           ($article->status === 'rejected' ? 'Refusé' : 'En attente') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $article->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.articles.show', $article) }}" 
                                           class="text-[#157e74] hover:text-[#1a9587]">
                                            Voir
                                        </a>
                                        @if($article->status === 'pending')
                                        <form action="{{ route('admin.articles.approve', $article) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                Valider
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.articles.reject', $article) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Refuser
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
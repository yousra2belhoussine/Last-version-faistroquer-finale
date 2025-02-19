@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Détails de l'article</h2>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.articles.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                            Retour à la liste
                        </a>
                    </div>
                </div>

                <!-- Informations de l'article -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $article->title }}</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Publié par {{ $article->user->name }} 
                            @if($article->published_at)
                                le {{ $article->published_at->format('d/m/Y H:i') }}
                            @endif
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($article->status === 'approved') bg-green-100 text-green-800
                                        @elseif($article->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Catégorie</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $article->category->name }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $article->description }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Images de l'article -->
                @if($article->images->count() > 0)
                <div class="mt-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Images</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($article->images as $image)
                        <div class="relative group">
                            <img src="{{ Storage::url($image->path) }}" 
                                 alt="Image de l'article" 
                                 class="w-full h-32 object-cover rounded-lg">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Actions administratives -->
                <div class="mt-6 flex justify-end space-x-3">
                    @if($article->status === 'pending')
                    <form action="{{ route('admin.articles.reject', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Rejeter
                        </button>
                    </form>
                    <form action="{{ route('admin.articles.approve', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Approuver
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
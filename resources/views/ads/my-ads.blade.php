@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('My Ads') }}</h2>
                    <a href="{{ route('ads.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        {{ __('Create New Ad') }}
                    </a>
                </div>

                @if($ads->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No ads yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new ad.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('ads.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                {{ __('Create New Ad') }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($ads as $ad)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if($ad->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">{{ __('No Image') }}</span>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <a href="{{ route('ads.show', $ad) }}" class="hover:text-indigo-600">
                                                {{ $ad->title }}
                                            </a>
                                        </h3>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($ad->status) }}
                                        </span>
                                    </div>

                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($ad->description, 100) }}</p>

                                    <div class="flex items-center justify-between text-sm mb-4">
                                        <span class="text-gray-500">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $ad->location }}
                                        </span>
                                        <span class="text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $ad->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->type === 'goods' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($ad->type) }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('ads.toggle-status', $ad) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                                                    {{ $ad->status === 'active' ? __('Pause') : __('Activate') }}
                                                </button>
                                            </form>
                                            <a href="{{ route('ads.edit', $ad) }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                                {{ __('Edit') }}
                                            </a>
                                            <form action="{{ route('ads.destroy', $ad) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this ad?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $ads->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
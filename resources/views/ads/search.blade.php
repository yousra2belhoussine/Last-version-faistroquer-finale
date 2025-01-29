@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('ads.search') }}" method="GET" class="space-y-6">
                    <!-- Basic Search -->
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label for="q" class="sr-only">{{ __('Search') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="q" 
                                       id="q" 
                                       value="{{ $searchQuery }}" 
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="{{ __('Search ads...') }}"
                                       autofocus>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Debug Info -->
        @if(config('app.debug'))
        <div class="bg-gray-100 p-4 mb-6 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Debug Info:</h3>
            <pre class="text-sm">
Search Query: {{ $searchQuery }}
Total Results: {{ $ads->total() }}
Current Page: {{ $ads->currentPage() }}
            </pre>
        </div>
        @endif

        <!-- Search Results -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($ads->count() > 0)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($ads as $ad)
                            <div class="bg-white overflow-hidden shadow rounded-lg">
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900 truncate">
                                        <a href="{{ route('ads.show', $ad) }}" class="hover:text-indigo-600">
                                            {{ $ad->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ Str::limit($ad->description, 100) }}
                                    </p>
                                    <div class="mt-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $ad->category->name }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $ad->type }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        {{ $ads->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No results found') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Try adjusting your search or filter to find what you are looking for.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
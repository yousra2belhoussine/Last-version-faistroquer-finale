@props(['ads'])

<div class="bg-white py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('Featured Ads') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
                {{ __('Check out our latest and most popular ads') }}
            </p>
        </div>

        <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($ads as $ad)
                <div class="group relative bg-white overflow-hidden rounded-lg shadow hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-h-2 aspect-w-3 bg-gray-200 group-hover:opacity-75">
                        @if($ad->images->isNotEmpty())
                            <img src="{{ Storage::url($ad->images->first()->path) }}" 
                                 alt="{{ $ad->title }}" 
                                 class="h-full w-full object-cover object-center">
                        @else
                            <div class="flex h-full items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('ads.show', $ad) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $ad->title }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ $ad->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->type === 'goods' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ __(ucfirst($ad->type)) }}
                                </span>
                                @if($ad->online_exchange)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ __('Online') }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $ad->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $ad->location }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('ads.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('View All Ads') }}
                <svg class="ml-2 -mr-1 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</div> 
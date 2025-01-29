@props(['categories'])

<div class="bg-gray-50 py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ __('Browse by Category') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
                {{ __('Find what you\'re looking for in our diverse categories') }}
            </p>
        </div>

        <div class="mt-12 grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach($categories as $category)
                <a href="{{ route('ads.category', $category) }}" 
                   class="group relative flex flex-col items-center justify-center rounded-lg bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="mb-4 rounded-full bg-indigo-50 p-3">
                        @if($category->icon)
                            <img src="{{ Storage::url($category->icon) }}" alt="{{ $category->name }}" class="h-8 w-8">
                        @else
                            <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 text-center">{{ $category->name }}</h3>
                    @if($category->ads_count)
                        <p class="mt-2 text-sm text-gray-500">
                            {{ trans_choice(':count ad|:count ads', $category->ads_count, ['count' => $category->ads_count]) }}
                        </p>
                    @endif
                    <div class="mt-4 text-sm font-medium text-indigo-600 group-hover:text-indigo-500">
                        {{ __('Browse Category') }}
                        <span aria-hidden="true"> &rarr;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div> 
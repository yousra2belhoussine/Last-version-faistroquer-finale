@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200 pb-10">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-4 text-base text-gray-500">{{ $category->description }}</p>
            @endif
        </div>

        <div class="pt-12 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
            <aside>
                <h2 class="sr-only">Filtres</h2>

                <!-- Mobile filter dialog -->
                <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
                    <!-- Background backdrop -->
                    <div class="fixed inset-0 bg-black bg-opacity-25"></div>
                </div>

                <div class="hidden lg:block">
                    <form class="space-y-10 divide-y divide-gray-200">
                        <!-- Type filter -->
                        <div>
                            <fieldset>
                                <legend class="block text-sm font-medium text-gray-900">Type</legend>
                                <div class="space-y-3 pt-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label class="ml-3 text-sm text-gray-600">Biens</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label class="ml-3 text-sm text-gray-600">Services</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Product grid -->
            <div class="mt-6 lg:col-span-2 lg:mt-0 xl:col-span-3">
                <!-- Grid -->
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                    @foreach($ads as $ad)
                    @php
                        $images = $ad->images ? json_decode($ad->images, true) : [];
                    @endphp
                    <div class="group relative">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200">
                            @if(is_array($images) && count($images) > 0)
                                <img src="{{ $images[0] }}" alt="{{ $ad->title }}" class="h-full w-full object-cover object-center group-hover:opacity-75">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-gray-100">
                                    <span class="text-gray-400">Pas d'image</span>
                                </div>
                            @endif
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="{{ route('ads.show', $ad) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $ad->title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $ad->type }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $ads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
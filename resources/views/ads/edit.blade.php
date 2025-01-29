@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Edit Ad') }}</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Update your ad details below.') }}
                    </p>
                </div>
                 <!-- Display Validation Errors -->
                 @if ($errors->any())
                 <div class="mb-4">
                     <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
                     <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
             @endif
                <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input
                            type="text"
                            name="title"
                            label="{{ __('Title') }}"
                            :value="old('title', $ad->title)"
                            required
                            autofocus
                        />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            {{ __('Description') }}
                        </label>
                        <div class="mt-1">
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                required
                            >{{ old('description', $ad->description) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            {{ __('Category') }}
                        </label>
                        <select
                            id="category_id"
                            name="category_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            required
                        >
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $ad->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">
                            {{ __('Type') }}
                        </label>
                        <select
                            id="type"
                            name="type"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            required
                        >
                            <option value="">{{ __('Select type') }}</option>
                            <option value="goods" @selected(old('type', $ad->type) == 'good')>{{ __('Good') }}</option>
                            <option value="services" @selected(old('type', $ad->type) == 'service')>{{ __('Service') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700">
                            {{ __('Condition') }}
                        </label>
                        <select
                            id="condition"
                            name="condition"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            required
                        >
                            <option value="">{{ __('Select condition') }}</option>
                            <option value="new" @selected(old('condition', $ad->condition) == 'new')>{{ __('New') }}</option>
                            <option value="like_new" @selected(old('condition', $ad->condition) == 'like_new')>{{ __('Like New') }}</option>
                            <option value="good" @selected(old('condition', $ad->condition) == 'good')>{{ __('Good') }}</option>
                            <option value="fair" @selected(old('condition', $ad->condition) == 'fair')>{{ __('Fair') }}</option>
                        </select>
                    </div>

                    <div>
                        <label for="region_id" class="block text-sm font-medium text-gray-700">
                            {{ __('Region') }}
                        </label>
                        <select
                            id="region_id"
                            name="region_id"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            required
                        >
                            <option value="">{{ __('Select region') }}</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" @selected(old('region_id', $ad->region_id) == $region->id)>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input
                            type="text"
                            name="department"
                            label="{{ __('Department') }}"
                            :value="old('department', $ad->department)"
                            required
                        />
                    </div>

                    <div>
                        <x-input
                            type="text"
                            name="city"
                            label="{{ __('City') }}"
                            :value="old('city', $ad->city)"
                            required
                        />
                    </div>

                    <div>
                        <x-input
                            type="text"
                            name="postal_code"
                            label="{{ __('Postal Code') }}"
                            :value="old('postal_code', $ad->postal_code)"
                            required
                        />
                    </div>

                    <div>
                        <x-input
                            type="text"
                            name="exchange_with"
                            label="{{ __('What would you like to exchange it with?') }}"
                            :value="old('exchange_with', $ad->exchange_with)"
                        />
                    </div>

                    <div class="flex items-center">
                        <input type="hidden" name="online_exchange" value="0">
                        <input
                            type="checkbox"
                            id="online_exchange"
                            name="online_exchange"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            value="1"
                            @checked(old('online_exchange', $ad->online_exchange))
                        >
                        <label for="online_exchange" class="ml-2 block text-sm text-gray-900">
                            {{ __('Available for online exchange') }}
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Current Images') }}
                        </label>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            @forelse($ad->images as $image)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="" class="h-24 w-full object-cover rounded">
                                    <div class="absolute top-0 right-0 flex space-x-1">
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="hidden" id="delete_image_{{ $image->id }}">
                                        <label for="delete_image_{{ $image->id }}" class="bg-red-500 text-white rounded-full p-1 cursor-pointer transform translate-x-1/2 -translate-y-1/2">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 col-span-2">{{ __('No images uploaded yet.') }}</p>
                            @endforelse
                        </div>

                        <label class="block text-sm font-medium text-gray-700">
                            {{ __('Upload New Images') }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>{{ __('Upload images') }}</span>
                                        <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                                    </label>
                                    <p class="pl-1">{{ __('or drag and drop') }}</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    {{ __('PNG, JPG, GIF up to 2MB') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('ads.my-ads') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                            {{ __('Cancel') }}
                        </a>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Update Ad') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview new images
    const input = document.querySelector('input[type="file"]');
    const preview = document.createElement('div');
    preview.className = 'grid grid-cols-2 gap-4 mt-4';
    input.parentElement.parentElement.parentElement.appendChild(preview);

    input.addEventListener('change', function() {
        preview.innerHTML = '';
        [...this.files].forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" class="h-24 w-full object-cover rounded">
                    <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2" onclick="this.parentElement.remove()">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Remove existing image
    function removeImage(button, imageId) {
        if (confirm('{{ __('Are you sure you want to remove this image?') }}')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_images[]';
            input.value = imageId;
            button.parentElement.parentElement.appendChild(input);
            button.parentElement.remove();
        }
    }
</script>
@endpush
@endsection
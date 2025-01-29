@props(['regions'])

<div class="relative isolate overflow-hidden bg-gradient-to-b from-indigo-100/20">
    <div class="mx-auto max-w-7xl pb-24 pt-10 sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-40">
        <div class="px-6 lg:px-0 lg:pt-4">
            <div class="mx-auto max-w-2xl">
                <div class="max-w-lg">
                    <h1 class="mt-10 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        {{ __('Exchange Goods and Services') }}
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        {{ __('Join our community of people exchanging goods and services. Find what you need or offer what you have.') }}
                    </p>
                    <div class="mt-10 flex items-center gap-x-6">
                        <a href="{{ route('ads.create') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            {{ __('Post an Ad') }}
                        </a>
                        <a href="{{ route('ads.index') }}" class="text-sm font-semibold leading-6 text-gray-900">
                            {{ __('Browse Ads') }} <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-2xl lg:mx-0 lg:mt-0 lg:w-screen">
            <div class="shadow-lg md:rounded-3xl">
                <div class="bg-white px-6 py-8 sm:px-8 sm:py-12 md:rounded-3xl">
                    <form action="{{ route('ads.search') }}" method="GET">
                        <div class="space-y-6">
                            <!-- Search Input -->
                            <div>
                                <label for="search" class="sr-only">{{ __('Search') }}</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="q" id="search" 
                                        class="block w-full rounded-md border-0 py-3 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                                        placeholder="{{ __('What are you looking for?') }}">
                                </div>
                            </div>

                            <!-- Region Select -->
                            <div>
                                <label for="region" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Region') }}</label>
                                <select id="region" name="region" class="mt-2 block w-full rounded-md border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                                    <option value="">{{ __('All Regions') }}</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type Select -->
                            <div>
                                <label for="type" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Type') }}</label>
                                <select id="type" name="type" class="mt-2 block w-full rounded-md border-0 py-3 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="goods">{{ __('Goods') }}</option>
                                    <option value="services">{{ __('Services') }}</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
</div> 
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('Browse Ads') }}</h2>
                    <a href="{{ route('ads.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        {{ __('Create New Ad') }}
                    </a>
                </div>

                <!-- Advanced Filters -->
                <form id="filter-form" method="GET" action="{{ route('ads.search') }}" class="mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Advanced Filters') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Search') }}</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="{{ __('Search ads...') }}">
                            </div>

                            <!-- Category -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category') }}</label>
                                <select name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('All Categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Type') }}</label>
                                <select name="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="goods" @selected(request('type') == 'goods')>{{ __('Goods') }}</option>
                                    <option value="services" @selected(request('type') == 'services')>{{ __('Services') }}</option>
                                </select>
                            </div>

                            <!-- Region -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Region') }}</label>
                                <select name="region" id="region" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('All Regions') }}</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->name }}" @selected(request('region') == $region->name)>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Department') }}</label>
                                <select name="department" id="department" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">{{ __('All Departments') }}</option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Location') }}</label>
                                <input type="text" name="location" value="{{ request('location') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="{{ __('Enter location') }}">
                            </div>
                        </div>

                        <div class="mt-4 flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="countdown" value="1" @checked(request('countdown')) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Show countdown ads first') }}</span>
                            </label>

                            <label class="inline-flex items-center">
                                <input type="checkbox" name="online_only" value="1" @checked(request('online_only')) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Online exchange only') }}</span>
                            </label>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                {{ __('Apply Filters') }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Active Filters -->
                @if(request()->anyFilled(['search', 'category', 'type', 'region', 'department', 'location', 'countdown', 'online_only']))
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">{{ __('Active Filters:') }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @if(request('search'))
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ __('Search:') }} {{ request('search') }}
                                    <button type="button" onclick="removeFilter('search')" class="ml-2 inline-flex text-indigo-400 hover:text-indigo-600">
                                        <span class="sr-only">{{ __('Remove filter') }}</span>
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                            <!-- Add similar spans for other active filters -->
                        </div>
                    </div>
                @endif

                <!-- Ads Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($ads as $ad)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($ad->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                                     alt="{{ $ad->title }}" 
                                     class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
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

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $ad->location }}
                                    </span>
                                    <span class="text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $ad->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @if($ad->expires_at)
                                    <div class="mt-2">
                                        <span class="text-sm text-red-600">
                                            {{ __('Expires') }}: {{ $ad->expires_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @endif

                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->type === 'goods' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($ad->type) }}
                                        </span>
                                        @if($ad->online_only)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ __('Online Only') }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('ads.show', $ad) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        {{ __('View Details') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <div class="text-gray-500">
                                {{ __('No ads found matching your criteria.') }}
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $ads->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle dynamic department loading based on selected region
    const regions = @json($regions->keyBy('name'));
    const regionSelect = document.getElementById('region');
    const departmentSelect = document.getElementById('department');

    function updateDepartments() {
        const selectedRegion = regionSelect.value;
        departmentSelect.innerHTML = '<option value="">{{ __('All Departments') }}</option>';

        if (selectedRegion && regions[selectedRegion]) {
            regions[selectedRegion].departments.forEach(department => {
                const option = new Option(department.name, department.name);
                option.selected = @json(request('department')) === department.name;
                departmentSelect.add(option);
            });
        }
    }

    regionSelect.addEventListener('change', updateDepartments);
    updateDepartments();

    // Handle filter removal
    function removeFilter(filterName) {
        const form = document.getElementById('filter-form');
        const input = form.querySelector(`[name="${filterName}"]`);
        if (input) {
            input.value = '';
        }
        form.submit();
    }

    // Auto-submit form on certain filter changes
    document.querySelectorAll('select, input[type="checkbox"]').forEach(element => {
        element.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });
</script>
@endpush
@endsection 
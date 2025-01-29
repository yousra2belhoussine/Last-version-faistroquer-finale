<div x-data="searchForm()" class="flex-1 max-w-3xl mx-auto">
    <form action="{{ route('ads.search') }}" method="GET" class="flex items-center gap-2">
        <!-- Location Selection -->
        <div class="relative" @click.away="isLocationOpen = false">
            <button type="button" 
                @click="isLocationOpen = !isLocationOpen"
                class="flex items-center px-3 py-2 border border-gray-300 rounded-md bg-white text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span x-text="selectedLocation || '{{ __('Select Location') }}'"></span>
            </button>

            <!-- Location Dropdown -->
            <div x-show="isLocationOpen" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
                
                <!-- Region Selection -->
                <div class="p-2">
                    <label class="block text-xs font-medium text-gray-700 mb-2">{{ __('Region') }}</label>
                    <select name="region" x-model="selectedRegionId" @change="loadDepartments" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">{{ __('All Regions') }}</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Department Selection -->
                <div class="p-2">
                    <label class="block text-xs font-medium text-gray-700 mb-2">{{ __('Department') }}</label>
                    <select name="department" x-model="selectedDepartmentId" :disabled="!departments.length" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">{{ __('All Departments') }}</option>
                        <template x-for="dept in departments" :key="dept.id">
                            <option :value="dept.id" x-text="dept.name"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <!-- Search Input -->
        <div class="flex-1 min-w-0">
            <div class="relative rounded-md shadow-sm">
                <input type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    class="block w-full rounded-md border-gray-300 pl-4 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                    placeholder="{{ __('Search ads...') }}">
                
                <!-- Advanced Search Button -->
                <div class="absolute inset-y-0 right-0 flex items-center">
                    <button type="button" 
                        @click="isAdvancedOpen = !isAdvancedOpen"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-r-md text-gray-500 bg-gray-50 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Button -->
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </form>

    <!-- Advanced Search Panel -->
    <div x-show="isAdvancedOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0"
        x-transition:enter-end="transform opacity-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100"
        x-transition:leave-end="transform opacity-0"
        class="absolute left-0 right-0 mt-2 mx-4 p-4 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Type') }}</label>
                <select name="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('All Types') }}</option>
                    <option value="goods" {{ request('type') === 'goods' ? 'selected' : '' }}>{{ __('Goods') }}</option>
                    <option value="services" {{ request('type') === 'services' ? 'selected' : '' }}>{{ __('Services') }}</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Category') }}</label>
                <select name="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('All Categories') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Additional Filters -->
            <div class="space-y-2">
                <label class="flex items-center">
                    <input type="checkbox" name="online_only" value="1" {{ request('online_only') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Online Exchange Only') }}</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox" name="with_countdown" value="1" {{ request('with_countdown') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('With Countdown') }}</span>
                </label>
            </div>
        </div>

        <!-- Sort Options -->
        <div class="mt-4 flex items-center justify-end space-x-4">
            <select name="sort" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>{{ __('Most Recent') }}</option>
                <option value="expires_at" {{ request('sort') === 'expires_at' ? 'selected' : '' }}>{{ __('Ending Soon') }}</option>
            </select>

            <select name="order" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>{{ __('Descending') }}</option>
                <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>{{ __('Ascending') }}</option>
            </select>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function searchForm() {
        return {
            isLocationOpen: false,
            isAdvancedOpen: false,
            selectedRegionId: '{{ request('region') }}',
            selectedDepartmentId: '{{ request('department') }}',
            departments: [],
            selectedLocation: '',

            async loadDepartments() {
                if (!this.selectedRegionId) {
                    this.departments = [];
                    this.selectedDepartmentId = '';
                    return;
                }

                try {
                    const response = await fetch(`/api/regions/${this.selectedRegionId}/departments`);
                    this.departments = await response.json();
                } catch (error) {
                    console.error('Error loading departments:', error);
                    this.departments = [];
                }
            },

            init() {
                if (this.selectedRegionId) {
                    this.loadDepartments();
                }

                this.$watch('selectedRegionId', (value) => {
                    if (!value) {
                        this.selectedLocation = '';
                    } else {
                        const region = document.querySelector(`select[name="region"] option[value="${value}"]`);
                        this.selectedLocation = region ? region.textContent : '';
                    }
                });

                this.$watch('selectedDepartmentId', (value) => {
                    if (value && this.departments.length) {
                        const dept = this.departments.find(d => d.id == value);
                        if (dept) {
                            this.selectedLocation = `${this.selectedLocation} - ${dept.name}`;
                        }
                    }
                });
            }
        }
    }
</script>
@endpush 
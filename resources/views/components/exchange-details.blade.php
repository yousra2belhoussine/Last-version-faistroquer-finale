@props(['ad'])

<div x-data="{ expanded: false }">
    <button type="button" 
            class="w-full flex items-center justify-between text-xl font-semibold text-[#157e74] mb-6 group"
            @click="expanded = !expanded">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>À échanger contre</span>
        </div>
        <svg class="ml-2 h-5 w-5 transform transition-transform duration-300"
             :class="{ 'rotate-180': expanded }"
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    
    <div x-show="expanded"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="bg-gradient-to-br from-[#157e74]/5 to-[#a3cca8]/5 rounded-2xl p-6">
        <p class="text-gray-700 leading-relaxed">{{ $ad->exchange_with }}</p>
    </div>
</div> 
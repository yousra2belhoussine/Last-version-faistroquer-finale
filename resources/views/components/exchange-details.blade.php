@props(['ad'])

<div class="border-t border-gray-100 pt-4">
    <button type="button" 
            class="text-[#157e74] hover:text-[#279078] font-medium flex items-center focus:outline-none group w-full"
            x-data="{ expanded: false }"
            x-on:click="expanded = !expanded">
        <span>À ÉCHANGER CONTRE</span>
        <svg class="ml-2 h-5 w-5 transform transition-transform duration-200"
             :class="{ 'rotate-180': expanded }"
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div class="exchange-details mt-4 pl-4 text-gray-600 border-l-2 border-[#157e74]/20"
         x-show="expanded"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        {{ $ad->exchange_with }}
    </div>
</div> 
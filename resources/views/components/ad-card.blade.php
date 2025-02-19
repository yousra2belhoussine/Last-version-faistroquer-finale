@props(['ad'])

<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-200">
    <div class="flex flex-col md:flex-row">
        <!-- Image à gauche -->
        <div class="md:w-1/3 relative">
            @if($ad->images->isNotEmpty())
                <img src="{{ $ad->images->first()->url }}" 
                     alt="{{ $ad->title }}" 
                     class="w-full h-64 md:h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none">
            @else
                <div class="w-full h-64 md:h-full bg-gradient-to-br from-[#6dbaaf]/20 to-[#a3cca8]/20 flex items-center justify-center rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none">
                    <span class="text-4xl text-[#157e74]">{{ substr($ad->title, 0, 1) }}</span>
                </div>
            @endif
            @if($ad->type)
                <div class="absolute top-4 right-4">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-[#157e74]/10 text-[#157e74]">
                        {{ $ad->type === 'goods' ? 'Bien' : 'Service' }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Contenu à droite -->
        <div class="flex-1 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xl font-medium text-gray-900">
                    <a href="{{ route('ads.show', $ad) }}" class="hover:text-[#157e74]">
                        {{ $ad->title }}
                    </a>
                </h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ad->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $ad->status === 'active' ? 'Actif' : 'En attente' }}
                </span>
            </div>

            <div class="flex items-center text-sm text-gray-500 mb-4">
                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $ad->location }}
            </div>

            <p class="text-gray-500 mb-4 line-clamp-2">{{ $ad->description }}</p>

            <x-exchange-details :ad="$ad" />

            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center text-sm text-[#6dbaaf]">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $ad->created_at->locale('fr')->diffForHumans() }}
                </div>
                @if($ad->category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#157e74]/10 text-[#157e74]">
                        {{ $ad->category->name }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</div> 
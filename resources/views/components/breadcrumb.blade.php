@props([
    'items' => [],
    'divider' => 'chevron',
    'homeIcon' => true,
    'responsive' => true
])

@php
    $dividers = [
        'chevron' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />',
        'slash' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" transform="rotate(45 12 12)" />',
        'dot' => '<circle cx="12" cy="12" r="1" stroke="none" fill="currentColor" />'
    ];

    $selectedDivider = $dividers[$divider] ?? $dividers['chevron'];
@endphp

<nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        @if($homeIcon)
            <li>
                <div>
                    <a href="/" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span class="sr-only">Home</span>
                    </a>
                </div>
            </li>
        @endif

        @foreach($items as $index => $item)
            <li>
                <div class="flex items-center">
                    @if($index > 0 || $homeIcon)
                        <svg class="h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $selectedDivider !!}
                        </svg>
                    @endif
                    
                    @if($responsive && !$loop->last)
                        <a href="{{ $item['url'] }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 hidden md:block">
                            {{ $item['label'] }}
                        </a>
                        <a href="{{ $item['url'] }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 md:hidden">
                            {{ \Illuminate\Support\Str::limit($item['label'], 10) }}
                        </a>
                    @else
                        <a href="{{ $item['url'] }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            {{ $item['label'] }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav> 
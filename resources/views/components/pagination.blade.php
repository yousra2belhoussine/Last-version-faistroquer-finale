@props([
    'paginator',
    'onEachSide' => 2,
    'size' => 'md',
    'simple' => false,
    'showInfo' => true
])

@php
    $sizes = [
        'sm' => [
            'button' => 'px-2 py-1 text-xs',
            'icon' => 'h-4 w-4'
        ],
        'md' => [
            'button' => 'px-3 py-2 text-sm',
            'icon' => 'h-5 w-5'
        ],
        'lg' => [
            'button' => 'px-4 py-2 text-base',
            'icon' => 'h-6 w-6'
        ]
    ];

    $buttonClasses = 'relative inline-flex items-center border border-gray-300 bg-white font-medium hover:bg-gray-50 ' . $sizes[$size]['button'];
    $activeClasses = 'z-10 border-indigo-500 bg-indigo-50 text-indigo-600';
    $disabledClasses = 'cursor-not-allowed bg-gray-100 text-gray-400';
    $iconClasses = $sizes[$size]['icon'];
@endphp

<div class="flex items-center justify-between">
    @if($showInfo)
        <div class="flex-1 text-sm text-gray-700">
            Showing
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium">{{ $paginator->total() }}</span>
            results
        </div>
    @endif

    <div class="@if($showInfo) sm:justify-end @else justify-center @endif flex flex-1 justify-between">
        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            {{-- Previous Page Link --}}
            @if($paginator->onFirstPage())
                <span class="{{ $buttonClasses }} {{ $disabledClasses }} rounded-l-md">
                    <span class="sr-only">Previous</span>
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="{{ $buttonClasses }} rounded-l-md">
                    <span class="sr-only">Previous</span>
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            @if(!$simple)
                {{-- Pagination Elements --}}
                @foreach($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if(is_string($element))
                        <span class="{{ $buttonClasses }} {{ $disabledClasses }}">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if(is_array($element))
                        @foreach($element as $page => $url)
                            @if($page == $paginator->currentPage())
                                <span class="{{ $buttonClasses }} {{ $activeClasses }}">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="{{ $buttonClasses }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- Next Page Link --}}
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="{{ $buttonClasses }} rounded-r-md">
                    <span class="sr-only">Next</span>
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="{{ $buttonClasses }} {{ $disabledClasses }} rounded-r-md">
                    <span class="sr-only">Next</span>
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </nav>
    </div>
</div> 
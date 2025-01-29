@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => null,
    'rounded' => true,
    'bordered' => false
])

@php
    $baseClasses = 'p-4';

    $types = [
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-400',
            'text' => 'text-blue-700',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-400',
            'text' => 'text-green-700',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-400',
            'text' => 'text-yellow-700',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-400',
            'text' => 'text-red-700',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
        ]
    ];

    $classes = $baseClasses . ' ' . 
        $types[$type]['bg'] . ' ' . 
        $types[$type]['text'] . ' ' .
        ($rounded ? 'rounded-lg' : '') . ' ' .
        ($bordered ? 'border ' . $types[$type]['border'] : '');
@endphp

<div x-data="{ show: true }" x-show="show" class="{{ $classes }}" role="alert">
    <div class="flex">
        @if($icon !== false)
            <div class="flex-shrink-0">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $icon ?? $types[$type]['icon'] !!}
                </svg>
            </div>
        @endif

        <div class="@if($icon !== false) ml-3 @endif flex-1">
            @if($title)
                <h3 class="text-sm font-medium">
                    {{ $title }}
                </h3>
            @endif

            <div class="@if($title) mt-2 @endif text-sm">
                {{ $slot }}
            </div>
        </div>

        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button type="button" @click="show = false" class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $types[$type]['bg'] }} {{ $types[$type]['text'] }} hover:bg-opacity-75">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div> 
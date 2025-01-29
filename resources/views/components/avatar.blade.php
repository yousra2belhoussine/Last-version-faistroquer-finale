@props([
    'size' => 'md',
    'src' => null,
    'alt' => '',
    'initials' => null,
    'status' => null,
    'statusPosition' => 'bottom-right',
    'bordered' => false,
    'rounded' => true,
    'stacked' => false
])

@php
    $baseClasses = 'inline-block relative flex-shrink-0';

    $sizes = [
        'xs' => 'h-6 w-6',
        'sm' => 'h-8 w-8',
        'md' => 'h-10 w-10',
        'lg' => 'h-12 w-12',
        'xl' => 'h-14 w-14',
        '2xl' => 'h-16 w-16'
    ];

    $initialsClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl'
    ];

    $statusSizes = [
        'xs' => 'h-1.5 w-1.5',
        'sm' => 'h-2 w-2',
        'md' => 'h-2.5 w-2.5',
        'lg' => 'h-3 w-3',
        'xl' => 'h-3.5 w-3.5',
        '2xl' => 'h-4 w-4'
    ];

    $statusPositions = [
        'top-right' => 'top-0 right-0',
        'top-left' => 'top-0 left-0',
        'bottom-right' => 'bottom-0 right-0',
        'bottom-left' => 'bottom-0 left-0'
    ];

    $statusColors = [
        'online' => 'bg-green-400',
        'offline' => 'bg-gray-400',
        'busy' => 'bg-red-400',
        'away' => 'bg-yellow-400'
    ];

    $stackedClasses = $stacked ? '-ml-2 ring-2 ring-white' : '';

    $classes = $baseClasses . ' ' . 
        $sizes[$size] . ' ' .
        ($rounded ? 'rounded-full' : 'rounded-md') . ' ' .
        ($bordered ? 'ring-2 ring-white' : '') . ' ' .
        $stackedClasses;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($src)
        <img class="h-full w-full object-cover {{ $rounded ? 'rounded-full' : 'rounded-md' }}"
            src="{{ $src }}"
            alt="{{ $alt }}">
    @else
        <span class="h-full w-full flex items-center justify-center bg-gray-100 {{ $rounded ? 'rounded-full' : 'rounded-md' }}">
            @if($initials)
                <span class="font-medium text-gray-600 {{ $initialsClasses[$size] }}">
                    {{ $initials }}
                </span>
            @else
                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            @endif
        </span>
    @endif

    @if($status)
        <span class="absolute {{ $statusPositions[$statusPosition] }} transform translate-y-1/2 translate-x-1/2 block {{ $statusSizes[$size] }}">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $statusColors[$status] }} opacity-75"></span>
            <span class="relative inline-flex rounded-full h-full w-full {{ $statusColors[$status] }}"></span>
        </span>
    @endif
</div> 
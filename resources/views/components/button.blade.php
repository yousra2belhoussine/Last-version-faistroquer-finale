@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false,
    'href' => null
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none transition duration-150 ease-in-out';

    $variants = [
        'primary' => 'text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
        'secondary' => 'text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
        'success' => 'text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500',
        'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500',
        'warning' => 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500',
        'info' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
        'light' => 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500',
        'dark' => 'text-white bg-gray-800 hover:bg-gray-900 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500',
        'link' => 'text-indigo-600 hover:text-indigo-900 underline bg-transparent'
    ];

    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm leading-4',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base',
        'xl' => 'px-6 py-3 text-base'
    ];

    $iconSizes = [
        'xs' => 'h-4 w-4',
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-5 w-5',
        'xl' => 'h-6 w-6'
    ];

    $iconSpacing = [
        'xs' => 'mr-1',
        'sm' => 'mr-1.5',
        'md' => 'mr-2',
        'lg' => 'mr-2',
        'xl' => 'mr-3'
    ];

    $classes = $baseClasses . ' ' . 
        $variants[$variant] . ' ' . 
        $sizes[$size] . ' ' .
        ($fullWidth ? 'w-full' : '') . ' ' .
        ($disabled || $loading ? 'opacity-50 cursor-not-allowed' : '');

    $iconClass = $iconSizes[$size] . ' ' . ($iconPosition === 'left' ? $iconSpacing[$size] : 'ml-2');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @else
            @if($icon && $iconPosition === 'left')
                <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $icon !!}
                </svg>
            @endif
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right' && !$loading)
            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @if($disabled || $loading) disabled @endif>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @else
            @if($icon && $iconPosition === 'left')
                <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $icon !!}
                </svg>
            @endif
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right' && !$loading)
            <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
    </button>
@endif 
@props([
    'type' => 'link',
    'href' => '#',
    'icon' => null,
    'disabled' => false,
    'destructive' => false
])

@php
    $baseClasses = 'group flex w-full items-center px-4 py-2 text-sm';

    $classes = $baseClasses . ' ' .
        ($disabled
            ? 'cursor-not-allowed opacity-50'
            : ($destructive
                ? 'text-red-700 hover:bg-red-50 hover:text-red-900 focus:bg-red-50 focus:text-red-900'
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900'));
@endphp

@if($type === 'button')
    <button {{ $attributes->merge(['class' => $classes, 'disabled' => $disabled]) }}>
        @if($icon)
            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </button>
@else
    <a href="{{ $disabled ? '#' : $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
        @endif
        {{ $slot }}
    </a>
@endif 
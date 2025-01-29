@props([
    'title' => null,
    'subtitle' => null,
    'footer' => null,
    'header' => null,
    'headerActions' => null,
    'padding' => true,
    'hover' => false,
    'bordered' => true,
    'rounded' => true,
    'shadow' => true
])

@php
    $baseClasses = 'bg-white overflow-hidden';

    $classes = $baseClasses . ' ' .
        ($bordered ? 'border border-gray-200' : '') . ' ' .
        ($rounded ? 'rounded-lg' : '') . ' ' .
        ($shadow ? 'shadow-sm' : '') . ' ' .
        ($hover ? 'transition duration-150 ease-in-out hover:shadow-md' : '');
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($header || $title || $headerActions)
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div>
                    @if($header)
                        {{ $header }}
                    @else
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{ $title }}
                        </h3>
                        @if($subtitle)
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ $subtitle }}
                            </p>
                        @endif
                    @endif
                </div>

                @if($headerActions)
                    <div class="flex-shrink-0">
                        {{ $headerActions }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div @class(['px-4 py-5 sm:p-6' => $padding])>
        {{ $slot }}
    </div>

    @if($footer)
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
            {{ $footer }}
        </div>
    @endif
</div> 
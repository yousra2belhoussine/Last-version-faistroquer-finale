@props([
    'type' => 'text',
    'label' => null,
    'error' => null,
    'helpText' => null,
    'leadingIcon' => null,
    'trailingIcon' => null,
    'leadingAddOn' => null,
    'trailingAddOn' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'size' => 'md'
])

@php
    $baseClasses = 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';

    $sizes = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-2 text-sm',
        'lg' => 'px-4 py-3 text-base'
    ];

    $hasLeading = $leadingIcon || $leadingAddOn;
    $hasTrailing = $trailingIcon || $trailingAddOn;

    $inputClasses = $baseClasses . ' ' . 
        $sizes[$size] . ' ' .
        ($hasLeading ? 'pl-10' : '') . ' ' .
        ($hasTrailing ? 'pr-10' : '') . ' ' .
        ($error ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : '') . ' ' .
        ($disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed' : '');
@endphp

<div>
    @if($label)
        <label for="{{ $attributes->get('id') }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-md shadow-sm">
        @if($hasLeading)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @if($leadingIcon)
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $leadingIcon !!}
                    </svg>
                @elseif($leadingAddOn)
                    <span class="text-gray-500 sm:text-sm">{{ $leadingAddOn }}</span>
                @endif
            </div>
        @endif

        @if($type === 'textarea')
            <textarea {{ $attributes->merge(['class' => $inputClasses]) }}
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                @if($required) required @endif>{{ $slot }}</textarea>
        @else
            <input type="{{ $type }}" {{ $attributes->merge(['class' => $inputClasses]) }}
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                @if($required) required @endif>
        @endif

        @if($hasTrailing)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                @if($trailingIcon)
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $trailingIcon !!}
                    </svg>
                @elseif($trailingAddOn)
                    <span class="text-gray-500 sm:text-sm">{{ $trailingAddOn }}</span>
                @endif
            </div>
        @endif

        @if($error)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($helpText && !$error)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div> 
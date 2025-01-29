@props([
    'label' => null,
    'error' => null,
    'helpText' => null,
    'placeholder' => null,
    'options' => [],
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'multiple' => false,
    'size' => 'md'
])

@php
    $baseClasses = 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';

    $sizes = [
        'sm' => 'py-1 text-xs',
        'md' => 'py-2 text-sm',
        'lg' => 'py-3 text-base'
    ];

    $selectClasses = $baseClasses . ' ' . 
        $sizes[$size] . ' ' .
        ($error ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500' : '') . ' ' .
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

    <div class="relative">
        <select {{ $attributes->merge(['class' => $selectClasses]) }}
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
            @if($multiple) multiple @endif>
            
            @if($placeholder && !$multiple)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $value => $label)
                @if(is_array($label))
                    <optgroup label="{{ $value }}">
                        @foreach($label as $groupValue => $groupLabel)
                            <option value="{{ $groupValue }}" @if(in_array($groupValue, (array)$attributes->get('value'))) selected @endif>
                                {{ $groupLabel }}
                            </option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $value }}" @if(in_array($value, (array)$attributes->get('value'))) selected @endif>
                        {{ $label }}
                    </option>
                @endif
            @endforeach
        </select>

        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        @if($error)
            <div class="absolute inset-y-0 right-8 pr-3 flex items-center pointer-events-none">
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

@once
    @push('styles')
        <style>
            select[multiple] {
                background-image: none;
                padding-right: 0.75rem;
            }
        </style>
    @endpush
@endonce 
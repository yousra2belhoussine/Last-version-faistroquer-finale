@props([
    'label' => null,
    'error' => null,
    'helpText' => null,
    'options' => [],
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'inline' => false,
    'size' => 'md'
])

@php
    $baseClasses = 'border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';

    $sizes = [
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6'
    ];

    $labelSizes = [
        'sm' => 'text-sm',
        'md' => 'text-base',
        'lg' => 'text-lg'
    ];

    $radioClasses = $baseClasses . ' ' . 
        $sizes[$size] . ' ' .
        ($error ? 'border-red-300 text-red-600 focus:border-red-300 focus:ring-red-200' : '') . ' ' .
        ($disabled ? 'bg-gray-100 cursor-not-allowed' : '');

    $groupClasses = $inline ? 'flex flex-wrap gap-4' : 'space-y-4';
@endphp

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="{{ $groupClasses }}">
        @foreach($options as $value => $optionLabel)
            <div class="flex items-center">
                <input type="radio"
                    name="{{ $attributes->get('name') }}"
                    id="{{ $attributes->get('name') }}_{{ $value }}"
                    value="{{ $value }}"
                    {{ $attributes->merge(['class' => $radioClasses]) }}
                    @if($attributes->get('value') == $value) checked @endif
                    @if($disabled) disabled @endif
                    @if($readonly) readonly onclick="return false;" @endif
                    @if($required) required @endif>
                
                <label for="{{ $attributes->get('name') }}_{{ $value }}" class="ml-3 {{ $labelSizes[$size] }} @if($disabled) opacity-50 @endif">
                    <span class="block font-medium text-gray-700">{{ $optionLabel }}</span>
                    @if(isset($descriptions[$value]))
                        <span class="block text-gray-500">{{ $descriptions[$value] }}</span>
                    @endif
                </label>
            </div>
        @endforeach
    </div>

    @if($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($helpText && !$error)
        <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
    @endif
</div> 
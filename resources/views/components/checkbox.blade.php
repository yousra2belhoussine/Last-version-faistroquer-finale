@props([
    'label' => null,
    'error' => null,
    'helpText' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'indeterminate' => false,
    'size' => 'md'
])

@php
    $baseClasses = 'rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';

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

    $checkboxClasses = $baseClasses . ' ' . 
        $sizes[$size] . ' ' .
        ($error ? 'border-red-300 text-red-600 focus:border-red-300 focus:ring-red-200' : '') . ' ' .
        ($disabled ? 'bg-gray-100 cursor-not-allowed' : '');
@endphp

<div class="flex items-start">
    <div class="flex items-center h-5">
        <input type="checkbox" {{ $attributes->merge(['class' => $checkboxClasses]) }}
            @if($disabled) disabled @endif
            @if($readonly) readonly onclick="return false;" @endif
            @if($required) required @endif>
    </div>
    
    @if($label || $helpText)
        <div class="ml-3 text-sm">
            @if($label)
                <label for="{{ $attributes->get('id') }}" class="font-medium text-gray-700 {{ $labelSizes[$size] }} @if($disabled) opacity-50 @endif">
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
            @endif

            @if($helpText && !$error)
                <p class="text-gray-500">{{ $helpText }}</p>
            @endif

            @if($error)
                <p class="mt-1 text-red-600">{{ $error }}</p>
            @endif
        </div>
    @endif
</div>

@if($indeterminate)
    @push('scripts')
        <script>
            document.getElementById('{{ $attributes->get('id') }}').indeterminate = true;
        </script>
    @endpush
@endif 
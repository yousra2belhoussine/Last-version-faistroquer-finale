@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-[#157e74] focus:ring-[#157e74] rounded-md shadow-sm']) !!}> 
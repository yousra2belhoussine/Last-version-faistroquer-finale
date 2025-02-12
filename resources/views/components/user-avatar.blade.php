@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-sm',
        'md' => 'h-10 w-10 text-base',
        'lg' => 'h-16 w-16 text-xl'
    ];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

@if($user->profile_photo_path)
    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
         alt="{{ $user->name }}" 
         class="{{ $sizeClasses }} rounded-full object-cover ring-2 ring-[#35a79b]/20"
         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
@else
    <div class="{{ $sizeClasses }} rounded-full bg-gradient-to-br from-[#35a79b] to-[#2c8a7e] flex items-center justify-center font-bold text-white shadow-sm">
        {{ substr($user->name, 0, 1) }}
    </div>
@endif 
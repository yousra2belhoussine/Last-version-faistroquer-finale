@props(['badge'])

<div {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-{{ $badge->color }}-100">
        <i class="fas fa-{{ $badge->icon }} text-{{ $badge->color }}-500 text-sm"></i>
    </div>
    @if(isset($showName) && $showName)
        <span class="ml-2 text-sm font-medium text-gray-700">{{ $badge->name }}</span>
    @endif
</div> 
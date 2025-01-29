@props([
    'tabs' => [],
    'selected' => null,
    'variant' => 'underline',
    'size' => 'md',
    'fullWidth' => false,
    'vertical' => false,
    'iconPosition' => 'left'
])

@php
    $baseClasses = 'group inline-flex items-center font-medium focus:outline-none';

    $variants = [
        'underline' => [
            'nav' => 'border-b border-gray-200',
            'tab' => 'border-b-2 border-transparent hover:border-gray-300 hover:text-gray-700',
            'selected' => 'border-indigo-500 text-indigo-600',
            'default' => 'text-gray-500',
            'disabled' => 'text-gray-400 cursor-not-allowed'
        ],
        'solid' => [
            'nav' => 'bg-gray-100 rounded-lg p-1',
            'tab' => 'rounded-md hover:bg-white hover:text-gray-700',
            'selected' => 'bg-white text-gray-900 shadow',
            'default' => 'text-gray-500',
            'disabled' => 'text-gray-400 cursor-not-allowed'
        ],
        'pill' => [
            'nav' => 'space-x-2',
            'tab' => 'rounded-full hover:bg-gray-100 hover:text-gray-700',
            'selected' => 'bg-indigo-100 text-indigo-700',
            'default' => 'text-gray-500',
            'disabled' => 'text-gray-400 cursor-not-allowed'
        ]
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base'
    ];

    $iconSizes = [
        'sm' => 'h-4 w-4',
        'md' => 'h-5 w-5',
        'lg' => 'h-6 w-6'
    ];

    $variantClasses = $variants[$variant];
    $navClasses = $variantClasses['nav'] . ' ' . ($vertical ? 'flex-col' : 'flex');
    $tabClasses = $baseClasses . ' ' . $variantClasses['tab'] . ' ' . $sizes[$size];
    $iconClass = $iconSizes[$size] . ' ' . ($iconPosition === 'left' ? 'mr-2' : 'ml-2');
@endphp

<div>
    <div class="@if($fullWidth) w-full @endif">
        <nav class="{{ $navClasses }}" aria-label="Tabs" role="tablist">
            @foreach($tabs as $tab)
                <button type="button"
                    id="tab-{{ $tab['id'] }}"
                    role="tab"
                    aria-controls="panel-{{ $tab['id'] }}"
                    aria-selected="{{ $selected === $tab['id'] ? 'true' : 'false' }}"
                    @if(!($tab['disabled'] ?? false))
                        @click="$dispatch('tab-selected', '{{ $tab['id'] }}')"
                    @endif
                    class="{{ $tabClasses }} {{ $selected === $tab['id'] ? $variantClasses['selected'] : $variantClasses['default'] }} {{ $tab['disabled'] ?? false ? $variantClasses['disabled'] : '' }} @if($fullWidth) flex-1 @endif">
                    @if(($tab['icon'] ?? false) && $iconPosition === 'left')
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $tab['icon'] !!}
                        </svg>
                    @endif

                    <span>{{ $tab['label'] }}</span>

                    @if(($tab['icon'] ?? false) && $iconPosition === 'right')
                        <svg class="{{ $iconClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $tab['icon'] !!}
                        </svg>
                    @endif

                    @if($tab['badge'] ?? false)
                        <span class="ml-2 rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-700">
                            {{ $tab['badge'] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </nav>
    </div>

    <div class="mt-2">
        {{ $slot }}
    </div>
</div>

@once
    @push('scripts')
        <script>
            window.addEventListener('tab-selected', event => {
                const tabId = event.detail;
                const tabs = document.querySelectorAll('[role="tab"]');
                const panels = document.querySelectorAll('[role="tabpanel"]');

                tabs.forEach(tab => {
                    const selected = tab.id === `tab-${tabId}`;
                    tab.setAttribute('aria-selected', selected);
                    tab.classList.toggle('{{ $variantClasses['selected'] }}', selected);
                    tab.classList.toggle('{{ $variantClasses['default'] }}', !selected);
                });

                panels.forEach(panel => {
                    panel.classList.toggle('hidden', panel.id !== `panel-${tabId}`);
                });
            });
        </script>
    @endpush
@endonce 
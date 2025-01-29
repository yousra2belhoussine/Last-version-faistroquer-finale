@props(['stats'])

<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:max-w-none">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ __('Trusted by Users Across France') }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    {{ __('Join our growing community of users exchanging goods and services') }}
                </p>
            </div>
            <dl class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex flex-col bg-gray-400/5 p-8">
                    <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('Active Ads') }}</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($stats['active_ads']) }}</dd>
                </div>
                <div class="flex flex-col bg-gray-400/5 p-8">
                    <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('Registered Users') }}</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($stats['users']) }}</dd>
                </div>
                <div class="flex flex-col bg-gray-400/5 p-8">
                    <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('Successful Exchanges') }}</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($stats['exchanges']) }}</dd>
                </div>
                <div class="flex flex-col bg-gray-400/5 p-8">
                    <dt class="text-sm font-semibold leading-6 text-gray-600">{{ __('Available Regions') }}</dt>
                    <dd class="order-first text-3xl font-semibold tracking-tight text-gray-900">{{ number_format($stats['regions']) }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div> 
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ __('My Exchange Propositions') }}</h2>
                </div>

                @if($propositions->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('No propositions yet') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('Start browsing ads to make exchange propositions.') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('ads.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Browse Ads') }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($propositions as $proposition)
                            <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            <a href="{{ route('propositions.show', $proposition) }}" class="hover:text-indigo-600">
                                                {{ $proposition->ad->title }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ __('Proposed by') }}: {{ $proposition->user->name }} • {{ $proposition->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($proposition->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($proposition->status === 'accepted') bg-green-100 text-green-800
                                        @elseif($proposition->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($proposition->status) }}
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-900">{{ __('Offer') }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ Str::limit($proposition->offer, 200) }}</p>
                                </div>

                                @if($proposition->message)
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900">{{ __('Message') }}</h4>
                                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($proposition->message, 200) }}</p>
                                    </div>
                                @endif

                                @if($proposition->isAccepted())
                                    <div class="mt-4 border-t border-gray-200 pt-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ __('Exchange Details') }}</h4>
                                                <p class="mt-1 text-sm text-gray-600">
                                                    @if($proposition->online_exchange)
                                                        {{ __('Online Exchange') }}
                                                    @else
                                                        {{ __('Meeting at') }}: {{ $proposition->meeting_location }}<br>
                                                        {{ __('Date') }}: {{ $proposition->meeting_date ? $proposition->meeting_date->format('F j, Y g:i A') : __('Not set') }}
                                                    @endif
                                                </p>
                                            </div>
                                            @if(Auth::id() === $proposition->ad->user_id)
                                                <form action="{{ route('propositions.complete', $proposition) }}" method="POST" class="ml-4">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                        {{ __('Mark as Completed') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-6 flex items-center justify-end space-x-4">
                                    <a href="{{ route('propositions.show', $proposition) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        {{ __('View Details') }}
                                    </a>

                                    @if($proposition->isPending() && Auth::id() === $proposition->ad->user_id)
                                        <form action="{{ route('propositions.accept', $proposition) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                {{ __('Accept') }}
                                            </button>
                                        </form>

                                        <form action="{{ route('propositions.reject', $proposition) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                                {{ __('Reject') }}
                                            </button>
                                        </form>
                                    @endif

                                    @if(($proposition->isPending() || $proposition->isAccepted()) && 
                                        (Auth::id() === $proposition->user_id || Auth::id() === $proposition->ad->user_id))
                                        <form action="{{ route('propositions.cancel', $proposition) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                {{ __('Cancel') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-6">
                            {{ $propositions->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 
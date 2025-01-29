<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Transactions
                        </a>
                    </div>

                    <!-- Transaction Header -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h1 class="text-3xl font-bold text-gray-900">Transaction Details</h1>
                        <p class="mt-2 text-sm text-gray-600">Transaction ID: {{ $transaction->id }}</p>
                    </div>

                    <!-- Transaction Status -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($transaction->status === 'completed') bg-green-100 text-green-800
                                @elseif($transaction->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                            <span class="ml-4 text-sm text-gray-600">
                                Created on {{ $transaction->created_at->format('F j, Y \a\t g:i A') }}
                            </span>
                        </div>
                    </div>

                    <!-- Ad Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ad Information</h2>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                @if($transaction->ad->images && count($transaction->ad->images) > 0)
                                    <img class="h-32 w-32 object-cover rounded-lg" src="{{ $transaction->ad->images[0] }}" alt="{{ $transaction->ad->title }}">
                                @else
                                    <div class="h-32 w-32 rounded-lg bg-indigo-100 flex items-center justify-center">
                                        <span class="text-4xl text-indigo-600">{{ substr($transaction->ad->title, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-6">
                                <h3 class="text-lg font-medium text-gray-900">{{ $transaction->ad->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $transaction->ad->category->name }}</p>
                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($transaction->ad->description, 200) }}</p>
                                <div class="mt-4">
                                    <a href="{{ route('ads.show', $transaction->ad) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Ad Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Participants -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Seller -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Seller</h2>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full" src="{{ $transaction->seller->profile_photo_url }}" alt="{{ $transaction->seller->name }}">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $transaction->seller->name }}</h3>
                                    <p class="text-sm text-gray-600">Member since {{ $transaction->seller->created_at->format('F Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Buyer -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Buyer</h2>
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full" src="{{ $transaction->buyer->profile_photo_url }}" alt="{{ $transaction->buyer->name }}">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $transaction->buyer->name }}</h3>
                                    <p class="text-sm text-gray-600">Member since {{ $transaction->buyer->created_at->format('F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Transaction Details</h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($transaction->type) }}</dd>
                            </div>
                            @if($transaction->price)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900">€{{ number_format($transaction->price, 2) }}</dd>
                                </div>
                            @endif
                            @if($transaction->exchange_item)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Exchange Item</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $transaction->exchange_item }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $transaction->location }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Actions -->
                    @if($transaction->status === 'pending' && (auth()->id() === $transaction->seller_id || auth()->id() === $transaction->buyer_id))
                        <div class="flex justify-end space-x-4">
                            @if(auth()->id() === $transaction->seller_id)
                                <form action="{{ route('transactions.accept', $transaction) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Accept Transaction
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('transactions.cancel', $transaction) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel Transaction
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Reviews -->
                    @if($transaction->status === 'completed')
                        <div class="mt-8 border-t border-gray-200 pt-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Reviews</h2>
                            
                            @if($transaction->reviews->isEmpty())
                                @if(auth()->id() === $transaction->seller_id || auth()->id() === $transaction->buyer_id)
                                    <div class="text-center py-6">
                                        <p class="text-sm text-gray-600">No reviews yet. Be the first to leave a review!</p>
                                        <div class="mt-4">
                                            <a href="{{ route('reviews.create', ['transaction' => $transaction->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Write a Review
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600">No reviews yet.</p>
                                @endif
                            @else
                                <div class="space-y-6">
                                    @foreach($transaction->reviews as $review)
                                        <div class="bg-gray-50 rounded-lg p-6">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" src="{{ $review->reviewer->profile_photo_url }}" alt="{{ $review->reviewer->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <h4 class="text-sm font-medium text-gray-900">{{ $review->reviewer->name }}</h4>
                                                    <div class="mt-1 flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-600">{{ $review->comment }}</p>
                                                    <p class="mt-2 text-xs text-gray-500">{{ $review->created_at->format('F j, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
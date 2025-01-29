<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8">My Transactions</h1>

                    @if($transactions->isEmpty())
                        <div class="text-center py-12">
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No transactions found</h3>
                            <p class="mt-1 text-sm text-gray-500">Start browsing ads to find items to exchange.</p>
                            <div class="mt-6">
                                <a href="{{ route('ads.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse Ads
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Ad
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Date
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($transactions as $transaction)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    @if($transaction->ad->images && count($transaction->ad->images) > 0)
                                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $transaction->ad->images[0] }}" alt="{{ $transaction->ad->title }}">
                                                                    @else
                                                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                            <span class="text-xl text-indigo-600">{{ substr($transaction->ad->title, 0, 1) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ $transaction->ad->title }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $transaction->ad->category->name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                @if($transaction->status === 'completed') bg-green-100 text-green-800
                                                                @elseif($transaction->status === 'cancelled') bg-red-100 text-red-800
                                                                @else bg-yellow-100 text-yellow-800
                                                                @endif">
                                                                {{ ucfirst($transaction->status) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $transaction->created_at->format('F j, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
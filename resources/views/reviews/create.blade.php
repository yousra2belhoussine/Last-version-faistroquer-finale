<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('transactions.show', $transaction) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Transaction
                        </a>
                    </div>

                    <!-- Review Form -->
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Write a Review</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Share your experience with this transaction. Your review will help other users make informed decisions.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                <input type="hidden" name="reviewed_id" value="{{ auth()->id() === $transaction->seller_id ? $transaction->buyer_id : $transaction->seller_id }}">

                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                        <!-- Rating -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Rating *</label>
                                            <div class="mt-2 flex items-center space-x-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <label class="rating-label cursor-pointer">
                                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only" {{ old('rating') == $i ? 'checked' : '' }} required>
                                                        <svg class="h-8 w-8 rating-star {{ old('rating') >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </label>
                                                @endfor
                                            </div>
                                            @error('rating')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Comment -->
                                        <div>
                                            <label for="comment" class="block text-sm font-medium text-gray-700">Comment *</label>
                                            <div class="mt-1">
                                                <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('comment') }}</textarea>
                                            </div>
                                            <p class="mt-2 text-sm text-gray-500">Write a detailed review about your experience. What went well? What could have been better?</p>
                                            @error('comment')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Submit Review
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingLabels = document.querySelectorAll('.rating-label');
            
            ratingLabels.forEach((label, index) => {
                label.addEventListener('mouseover', () => {
                    // Highlight stars up to the current one
                    ratingLabels.forEach((l, i) => {
                        const star = l.querySelector('.rating-star');
                        if (i <= index) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                });

                label.addEventListener('click', () => {
                    // Set the rating
                    const radio = label.querySelector('input[type="radio"]');
                    radio.checked = true;

                    // Update stars
                    ratingLabels.forEach((l, i) => {
                        const star = l.querySelector('.rating-star');
                        if (i <= index) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                });
            });

            // Reset stars when mouse leaves the container
            const ratingContainer = document.querySelector('.rating-container');
            ratingContainer?.addEventListener('mouseleave', () => {
                const selectedRating = document.querySelector('input[name="rating"]:checked')?.value;
                ratingLabels.forEach((label, index) => {
                    const star = label.querySelector('.rating-star');
                    if (selectedRating && index < selectedRating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout> 
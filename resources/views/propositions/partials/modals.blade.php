<!-- Modale de confirmation pour Accepter -->
<div id="accept-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Centre la modale -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Contenu de la modale -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ __('Confirmer l\'acceptation') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Êtes-vous sûr de vouloir accepter cette proposition d\'échange ? Cette action ne peut pas être annulée.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="{{ route('propositions.accept', $proposition) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#35a79b] text-base font-medium text-white hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmer') }}
                    </button>
                </form>
                <button type="button" onclick="hideAcceptModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('Annuler') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modale de confirmation pour Refuser -->
<div id="reject-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Centre la modale -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Contenu de la modale -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ __('Confirmer le refus') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Êtes-vous sûr de vouloir refuser cette proposition d\'échange ? Cette action ne peut pas être annulée.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="{{ route('propositions.reject', $proposition) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmer') }}
                    </button>
                </form>
                <button type="button" onclick="hideRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    {{ __('Annuler') }}
                </button>
            </div>
        </div>
    </div>
</div>

@if($proposition->isAccepted() && !$proposition->isCompleted() && !$proposition->online_exchange)
<!-- Modal de mise à jour du rendez-vous -->
<div id="update-meeting-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('propositions.update-meeting', $proposition) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                        {{ __('Modifier les détails du rendez-vous') }}
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label for="meeting_location" class="block text-sm font-medium text-gray-700">
                                {{ __('Lieu du rendez-vous') }}
                            </label>
                            <input type="text" name="meeting_location" id="meeting_location" 
                                   value="{{ $proposition->meeting_location }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b] sm:text-sm" 
                                   required>
                        </div>
                        <div>
                            <label for="meeting_date" class="block text-sm font-medium text-gray-700">
                                {{ __('Date et heure du rendez-vous') }}
                            </label>
                            <input type="datetime-local" name="meeting_date" id="meeting_date" 
                                   value="{{ $proposition->meeting_date ? $proposition->meeting_date->format('Y-m-d\TH:i') : '' }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b] sm:text-sm" 
                                   required>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#35a79b] text-base font-medium text-white hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Mettre à jour') }}
                    </button>
                    <button type="button" onclick="hideUpdateMeetingModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Annuler') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif 

<!-- Modale de complétion avec feedback -->
<div id="complete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Centre la modale -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Contenu de la modale -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('propositions.complete', $proposition) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start mb-6">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-[#35a79b] bg-opacity-10 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-[#35a79b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ __('Confirmer la complétion de l\'échange') }}
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    {{ __('En confirmant la complétion, vous indiquez que l\'échange a été réalisé avec succès. Merci de laisser un feedback pour votre expérience.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Feedback -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Note') }}</label>
                            <div class="flex space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            onclick="setCompletionRating({{ $i }})"
                                            class="completion-rating-star text-gray-300 hover:text-yellow-400 transition-colors duration-150"
                                            data-rating="{{ $i }}">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="completion-rating-input" value="" required>
                            </div>
                        </div>
                        <div>
                            <label for="completion-comment" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('Commentaire') }}
                            </label>
                            <textarea
                                id="completion-comment"
                                name="comment"
                                rows="3"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b] sm:text-sm"
                                placeholder="{{ __('Partagez votre expérience concernant cet échange...') }}"
                                required
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#35a79b] text-base font-medium text-white hover:bg-[#2c8c82] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmer et envoyer le feedback') }}
                    </button>
                    <button type="button" onclick="hideCompleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#35a79b] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Annuler') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showCompleteModal() {
    document.getElementById('complete-modal').classList.remove('hidden');
}

function hideCompleteModal() {
    document.getElementById('complete-modal').classList.add('hidden');
}

function setCompletionRating(rating) {
    document.getElementById('completion-rating-input').value = rating;
    const stars = document.querySelectorAll('.completion-rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < rating);
        star.classList.toggle('text-gray-300', index >= rating);
    });
}
</script>
@endpush 
<!-- Modal pour faire une proposition d'échange -->
<div id="propositionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 overflow-hidden shadow-xl transform transition-all">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="closePropositionModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Faire une proposition d'échange
                </h3>

                <form id="propositionForm" class="mt-2">
                    @csrf
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Titre de votre proposition
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                   placeholder="Ex: Je propose mon vélo contre votre skateboard">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Description détaillée
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                    placeholder="Décrivez en détail ce que vous proposez en échange..."></textarea>
                        </div>

                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Photos (optionnel)
                            </label>
                            <input type="file" name="images[]" id="images" multiple
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#157e74]/10 file:text-[#157e74] hover:file:bg-[#157e74]/20">
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6">
                        <button type="submit"
                                class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                            Envoyer la proposition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openPropositionModal() {
    document.getElementById('propositionModal').classList.remove('hidden');
}

function closePropositionModal() {
    document.getElementById('propositionModal').classList.add('hidden');
}

document.getElementById('propositionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/propositions', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closePropositionModal();
            // Afficher une notification de succès
            alert('Proposition envoyée avec succès !');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de l\'envoi de la proposition.');
    });
});
</script> 
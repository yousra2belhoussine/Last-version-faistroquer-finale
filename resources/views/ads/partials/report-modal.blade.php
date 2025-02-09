<!-- Modal pour signaler une annonce -->
<div id="reportModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 overflow-hidden shadow-xl transform transition-all">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="closeReportModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Signaler cette annonce
                </h3>

                <form id="reportForm" class="mt-2">
                    @csrf
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Motif du signalement
                            </label>
                            <select name="reason" id="reason" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]">
                                <option value="">Sélectionnez un motif</option>
                                <option value="inappropriate">Contenu inapproprié</option>
                                <option value="fake">Annonce frauduleuse</option>
                                <option value="offensive">Contenu offensant</option>
                                <option value="spam">Spam</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Description détaillée
                            </label>
                            <textarea name="description" id="description" rows="4" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                    placeholder="Expliquez en détail pourquoi vous signalez cette annonce..."></textarea>
                        </div>
                    </div>

                    <div class="mt-5 sm:mt-6">
                        <button type="submit"
                                class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-red-600 hover:bg-red-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                            Envoyer le signalement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openReportModal() {
    document.getElementById('reportModal').classList.remove('hidden');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
}

document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/reports', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeReportModal();
            // Afficher une notification de succès
            alert('Signalement envoyé avec succès !');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de l\'envoi du signalement.');
    });
});
</script> 
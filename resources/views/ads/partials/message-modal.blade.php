<!-- Modal pour envoyer un message -->
<div id="messageModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl max-w-lg w-full p-6 overflow-hidden shadow-xl transform transition-all">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button type="button" onclick="closeMessageModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Fermer</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Envoyer un message au vendeur
                </h3>

                <form id="messageForm" class="mt-2">
                    @csrf
                    <input type="hidden" name="ad_id" value="{{ $ad->id }}">
                    <input type="hidden" name="recipient_id" value="{{ $ad->user_id }}">
                    
                    <div class="mt-4">
                        <textarea name="message" rows="4" 
                                class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                placeholder="Votre message..."></textarea>
                    </div>

                    <div class="mt-5 sm:mt-6">
                        <button type="submit"
                                class="w-full flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] transform hover:-translate-y-0.5 transition-all duration-200 shadow-md hover:shadow-lg">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openMessageModal() {
    document.getElementById('messageModal').classList.remove('hidden');
}

function closeMessageModal() {
    document.getElementById('messageModal').classList.add('hidden');
}

document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/messages', {
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
            closeMessageModal();
            // Afficher une notification de succès
            alert('Message envoyé avec succès !');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue lors de l\'envoi du message.');
    });
});
</script> 
<!-- Modal pour faire une proposition d'échange -->
<div id="propositionModal" class="fixed inset-0 z-40 hidden overflow-y-auto">
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
                            <label for="offer" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Votre offre
                            </label>
                            <input type="text" name="offer" id="offer" required
                                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                   placeholder="Ex: Je propose mon vélo contre votre skateboard">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                Message (optionnel)
                            </label>
                            <textarea name="message" id="message" rows="4" 
                                    class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                    placeholder="Ajoutez des détails sur votre proposition..."></textarea>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="online_exchange" id="online_exchange" 
                                   class="rounded border-gray-300 text-[#157e74] focus:ring-[#157e74]">
                            <label for="online_exchange" class="ml-2 block text-sm text-gray-700">
                                Échange en ligne
                            </label>
                        </div>

                        <div id="meeting-details" class="space-y-4">
                            <div>
                                <label for="meeting_location" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                    Lieu de rencontre
                                </label>
                                <input type="text" name="meeting_location" id="meeting_location"
                                       class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]"
                                       placeholder="Ex: Centre commercial">
                            </div>

                            <div>
                                <label for="meeting_date" class="block text-sm font-medium text-gray-700 text-left mb-1">
                                    Date de rencontre
                                </label>
                                <input type="datetime-local" name="meeting_date" id="meeting_date"
                                       class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]">
                            </div>
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

<!-- Notification de succès (déplacée en dehors du modal) -->
<div id="successNotification" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-[#157e74] text-white px-8 py-6 rounded-xl shadow-2xl flex items-center transform transition-all duration-300 ease-out scale-90 opacity-0">
        <svg class="w-8 h-8 mr-3 flex-shrink-0 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="text-lg font-medium">Proposition envoyée avec succès !</span>
    </div>
</div>

<script>
function openPropositionModal() {
    document.getElementById('propositionModal').classList.remove('hidden');
}

function closePropositionModal() {
    document.getElementById('propositionModal').classList.add('hidden');
}

function showSuccessNotification() {
    const notification = document.getElementById('successNotification');
    const notificationContent = notification.querySelector('div');
    
    // Afficher la notification
    notification.classList.remove('hidden');
    
    // Animer l'apparition
    setTimeout(() => {
        notificationContent.classList.remove('scale-90', 'opacity-0');
        notificationContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Masquer après 3 secondes
    setTimeout(() => {
        notificationContent.classList.remove('scale-100', 'opacity-100');
        notificationContent.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 300);
    }, 3000);
}

document.getElementById('propositionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });
    
    fetch('{{ route("propositions.store", $ad) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Une erreur est survenue');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closePropositionModal();
            showSuccessNotification();
            // Recharger la page après un délai
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Une erreur est survenue lors de l\'envoi de la proposition.');
    });
});

// Gestion de l'affichage des champs de rencontre
document.getElementById('online_exchange').addEventListener('change', function() {
    const meetingDetails = document.getElementById('meeting-details');
    const meetingLocation = document.getElementById('meeting_location');
    const meetingDate = document.getElementById('meeting_date');
    
    if (this.checked) {
        meetingDetails.style.display = 'none';
        meetingLocation.removeAttribute('required');
        meetingDate.removeAttribute('required');
    } else {
        meetingDetails.style.display = 'block';
        meetingLocation.setAttribute('required', 'required');
        meetingDate.setAttribute('required', 'required');
    }
});

// Initialiser l'état des champs de rencontre au chargement
document.addEventListener('DOMContentLoaded', function() {
    const onlineExchange = document.getElementById('online_exchange');
    const meetingDetails = document.getElementById('meeting-details');
    const meetingLocation = document.getElementById('meeting_location');
    const meetingDate = document.getElementById('meeting_date');
    
    if (onlineExchange.checked) {
        meetingDetails.style.display = 'none';
        meetingLocation.removeAttribute('required');
        meetingDate.removeAttribute('required');
    } else {
        meetingDetails.style.display = 'block';
        meetingLocation.setAttribute('required', 'required');
        meetingDate.setAttribute('required', 'required');
    }
});
</script> 
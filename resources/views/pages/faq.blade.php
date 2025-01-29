@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl lg:text-6xl bg-clip-text text-transparent bg-gradient-to-r from-[#35a79b] to-[#79d8b2]">
                Questions fréquentes
            </h1>
            <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                Trouvez rapidement des réponses à vos questions sur FAISTROQUER
            </p>
        </div>

        <!-- FAQ Categories -->
        <div class="mt-20">
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- General Category -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Questions générales</h2>
                        </div>
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Qu'est-ce que FAISTROQUER ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">FAISTROQUER est une plateforme d'échange de biens et services entre particuliers. Elle permet aux utilisateurs de troquer leurs objets ou compétences sans utiliser d'argent.</p>
                                </div>
                            </div>
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Est-ce gratuit ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">Oui, l'inscription et l'utilisation de base de la plateforme sont totalement gratuites.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exchange Process Category -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Processus d'échange</h2>
                        </div>
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Comment fonctionne un échange ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">Les échanges se déroulent en plusieurs étapes : proposition, discussion, accord mutuel, et enfin l'échange physique ou en ligne selon la nature des biens ou services.</p>
                                </div>
                            </div>
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Comment garantir un échange sûr ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">Nous recommandons de bien vérifier les profils des utilisateurs, de communiquer via notre plateforme, et de suivre nos conseils de sécurité pour les rencontres en personne.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account & Security Category -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center mb-6">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h2 class="ml-4 text-xl font-semibold text-gray-900">Compte & Sécurité</h2>
                        </div>
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Comment fonctionne le système de confiance ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">Notre système de confiance est basé sur les évaluations des utilisateurs, les badges obtenus et l'historique des échanges réussis.</p>
                                </div>
                            </div>
                            <div class="border-b border-gray-200 pb-6">
                                <button class="flex justify-between items-center w-full text-left" onclick="toggleFaq(this)">
                                    <span class="text-lg font-medium text-gray-900">Comment protéger mon compte ?</span>
                                    <svg class="h-6 w-6 text-[#35a79b] transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="mt-4 hidden">
                                    <p class="text-gray-600">Utilisez un mot de passe fort, activez l'authentification à deux facteurs si disponible, et ne partagez jamais vos identifiants.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Still Need Help Section -->
        <div class="mt-20 text-center">
            <div class="bg-white rounded-2xl p-8 shadow-sm inline-block">
                <h2 class="text-xl font-semibold text-gray-900">Vous n'avez pas trouvé la réponse à votre question ?</h2>
                <p class="mt-4 text-gray-600">Notre équipe de support est là pour vous aider.</p>
                <div class="mt-6">
                    <a href="{{ route('help') }}" 
                       class="inline-flex items-center px-6 py-3 rounded-full text-base font-medium text-white bg-[#35a79b] hover:bg-[#2c8d83] transition-colors shadow-sm hover:shadow">
                        Contacter le support
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('svg');
    
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        answer.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endpush

@endsection 
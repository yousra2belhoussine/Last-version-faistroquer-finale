@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl lg:text-6xl bg-clip-text text-transparent bg-gradient-to-r from-[#35a79b] to-[#79d8b2]">
                Comment fonctionne FAISTROQUER ?
            </h1>
            <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                Un guide complet pour bien démarrer sur notre plateforme d'échange
            </p>
        </div>

        <!-- Steps Section -->
        <div class="mt-20">
            <div class="space-y-12">
                <!-- Section 1: Création de compte -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">1. Créez votre compte</h2>
                                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                                    L'inscription est gratuite et ne prend que quelques minutes. Choisissez entre un compte personnel ou professionnel.
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('register') }}" 
                                       class="inline-flex items-center px-6 py-3 rounded-full text-base font-medium text-white bg-[#35a79b] hover:bg-[#2c8d83] transition-colors shadow-sm hover:shadow">
                                        S'inscrire maintenant
                                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Publication d'annonces -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">2. Publiez vos annonces</h2>
                                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                                    Décrivez ce que vous proposez et ce que vous recherchez. Ajoutez des photos de qualité pour augmenter vos chances d'échange.
                                </p>
                                <div class="mt-6">
                                    <a href="{{ route('ads.create') }}" 
                                       class="inline-flex items-center px-6 py-3 rounded-full text-base font-medium text-white bg-[#35a79b] hover:bg-[#2c8d83] transition-colors shadow-sm hover:shadow">
                                        Créer une annonce
                                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Échanges -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">3. Échangez en toute confiance</h2>
                                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                                    Discutez avec les autres membres, faites des propositions et convenez des modalités d'échange en toute sécurité.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Système de confiance -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold text-gray-900">4. Gagnez en crédibilité</h2>
                                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                                    Complétez des échanges avec succès, recevez des avis positifs et gagnez des badges pour augmenter votre score de confiance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-24">
            <h2 class="text-3xl font-bold text-center text-gray-900">Questions fréquentes</h2>
            <div class="mt-12 grid gap-8 lg:grid-cols-2">
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900">Est-ce gratuit ?</h3>
                    <p class="mt-4 text-gray-600">
                        Oui, l'inscription et l'utilisation de base de la plateforme sont totalement gratuites.
                    </p>
                </div>
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                    <h3 class="text-xl font-semibold text-gray-900">Comment fonctionne la sécurité ?</h3>
                    <p class="mt-4 text-gray-600">
                        Nous utilisons un système de notation et de badges pour établir la confiance entre les membres.
                    </p>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('faq') }}" 
                   class="inline-flex items-center text-[#35a79b] hover:text-[#2c8d83] font-medium">
                    Voir toutes les questions fréquentes
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mt-24 text-center">
            <div class="bg-white rounded-2xl p-8 shadow-sm inline-block">
                <h2 class="text-xl font-semibold text-gray-900">Besoin d'aide supplémentaire ?</h2>
                <p class="mt-4 text-gray-600">Notre équipe de support est là pour vous aider.</p>
                <div class="mt-6">
                    <a href="{{ route('help') }}" 
                       class="inline-flex items-center px-6 py-3 rounded-full text-base font-medium text-white bg-[#35a79b] hover:bg-[#2c8d83] transition-colors shadow-sm hover:shadow">
                        Contactez le support
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
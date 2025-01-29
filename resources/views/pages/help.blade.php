@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl lg:text-6xl bg-clip-text text-transparent bg-gradient-to-r from-[#35a79b] to-[#79d8b2]">
                Centre d'aide
            </h1>
            <p class="mt-6 text-xl text-gray-600 leading-relaxed">
                Nous sommes là pour vous aider à tirer le meilleur parti de FAISTROQUER
            </p>
        </div>

        <!-- Main Content -->
        <div class="mt-20">
            <div class="grid gap-8 lg:grid-cols-2">
                <!-- Contact Support Card -->
                <div class="transform transition-all hover:scale-[1.02]">
                    <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow h-full">
                        <div class="flex flex-col h-full">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-[#35a79b] text-white mb-6">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Contactez le support</h2>
                                <p class="mt-4 text-lg text-gray-600 leading-relaxed">
                                    Notre équipe de support est disponible pour répondre à toutes vos questions et vous aider à résoudre vos problèmes.
                                </p>
                                <form class="mt-6 space-y-4">
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" id="email" name="email" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b]">
                                    </div>
                                    <div>
                                        <label for="subject" class="block text-sm font-medium text-gray-700">Sujet</label>
                                        <input type="text" id="subject" name="subject" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b]">
                                    </div>
                                    <div>
                                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#35a79b] focus:ring-[#35a79b]"></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit" class="inline-flex items-center px-6 py-3 rounded-full text-base font-medium text-white bg-[#35a79b] hover:bg-[#2c8d83] transition-colors shadow-sm hover:shadow">
                                            Envoyer le message
                                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Help Section -->
                <div class="space-y-8">
                    <!-- FAQ Card -->
                    <div class="transform transition-all hover:scale-[1.02]">
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="ml-4 text-xl font-semibold text-gray-900">Questions fréquentes</h3>
                            </div>
                            <p class="text-gray-600">
                                Consultez notre FAQ pour trouver rapidement des réponses à vos questions.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('faq') }}" class="inline-flex items-center text-[#35a79b] hover:text-[#2c8d83] font-medium">
                                    Voir la FAQ
                                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Guide Card -->
                    <div class="transform transition-all hover:scale-[1.02]">
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="ml-4 text-xl font-semibold text-gray-900">Guide d'utilisation</h3>
                            </div>
                            <p class="text-gray-600">
                                Découvrez comment utiliser toutes les fonctionnalités de FAISTROQUER.
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('how-it-works') }}" class="inline-flex items-center text-[#35a79b] hover:text-[#2c8d83] font-medium">
                                    Voir le guide
                                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Community Card -->
                    <div class="transform transition-all hover:scale-[1.02]">
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center mb-6">
                                <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-[#35a79b] text-white">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h3 class="ml-4 text-xl font-semibold text-gray-900">Communauté</h3>
                            </div>
                            <p class="text-gray-600">
                                Rejoignez notre communauté pour échanger avec d'autres membres et partager vos expériences.
                            </p>
                            <div class="mt-4">
                                <a href="#" class="inline-flex items-center text-[#35a79b] hover:text-[#2c8d83] font-medium">
                                    Rejoindre la communauté
                                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
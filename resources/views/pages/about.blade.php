@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-[#157e74]/10 to-[#a3cca8]/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-[#157e74] mb-8">À propos de FAISTROQUER</h1>
            
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h2 class="text-xl font-semibold text-[#157e74] mb-4">Notre Mission</h2>
                <p class="text-gray-600 mb-6">
                    FAISTROQUER est né d'une vision simple : créer une communauté d'échange collaborative où les biens et services trouvent une seconde vie. Notre plateforme facilite les échanges directs entre particuliers, encourageant une consommation plus responsable et durable.
                </p>
                
                <h2 class="text-xl font-semibold text-[#157e74] mb-4">Nos Valeurs</h2>
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-medium text-[#157e74] mb-2">Durabilité</h3>
                        <p class="text-gray-600">Nous encourageons la réutilisation et le partage pour réduire notre impact environnemental.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-[#157e74] mb-2">Communauté</h3>
                        <p class="text-gray-600">Nous créons des liens entre les membres pour faciliter les échanges locaux.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-[#157e74] mb-2">Confiance</h3>
                        <p class="text-gray-600">Nous assurons un environnement sécurisé pour tous nos utilisateurs.</p>
                    </div>
                    <div>
                        <h3 class="font-medium text-[#157e74] mb-2">Innovation</h3>
                        <p class="text-gray-600">Nous développons constamment de nouvelles fonctionnalités pour améliorer l'expérience.</p>
                    </div>
                </div>
                
                <h2 class="text-xl font-semibold text-[#157e74] mb-4">Comment ça marche ?</h2>
                <div class="space-y-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#157e74] rounded-full flex items-center justify-center text-white font-semibold mr-4">1</div>
                        <div>
                            <h3 class="font-medium text-gray-900">Créez votre compte</h3>
                            <p class="text-gray-600">Inscrivez-vous gratuitement et commencez à explorer les annonces.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#157e74] rounded-full flex items-center justify-center text-white font-semibold mr-4">2</div>
                        <div>
                            <h3 class="font-medium text-gray-900">Publiez vos annonces</h3>
                            <p class="text-gray-600">Partagez les biens ou services que vous souhaitez échanger.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-[#157e74] rounded-full flex items-center justify-center text-white font-semibold mr-4">3</div>
                        <div>
                            <h3 class="font-medium text-gray-900">Échangez en toute confiance</h3>
                            <p class="text-gray-600">Discutez avec les membres et réalisez vos échanges en toute sécurité.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-semibold text-[#157e74] mb-4">Rejoignez notre communauté</h2>
                <p class="text-gray-600 mb-6">
                    Faites partie d'une communauté grandissante de personnes qui choisissent un mode de consommation plus responsable et collaboratif.
                </p>
                <div class="flex space-x-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#279078]">
                        S'inscrire gratuitement
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-[#157e74] text-sm font-medium rounded-md text-[#157e74] hover:bg-[#157e74] hover:text-white">
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
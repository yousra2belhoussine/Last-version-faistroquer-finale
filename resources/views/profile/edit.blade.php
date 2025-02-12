@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow-lg sm:rounded-xl">
            <div class="max-w-xl mx-auto">
                <header class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('Informations du profil') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Mettez à jour les informations de votre profil et votre adresse email.') }}
                    </p>
                </header>

                <!-- Photo de profil -->
                <div class="mb-6">
                    <form id="profile-photo-form" action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-6">
                        @csrf
                        @method('patch')
                        
                        <div class="shrink-0">
                            <div class="relative h-24 w-24">
                                @if(auth()->user()->profile_photo_path)
                                    <img id="preview-photo" 
                                         src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" 
                                         alt="{{ auth()->user()->name }}"
                                         class="h-24 w-24 object-cover rounded-full border-4 border-white shadow-lg"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-emerald-500 flex items-center justify-center text-white text-2xl font-bold border-4 border-white shadow-lg">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <label class="block">
                                <span class="sr-only">Choisir une photo</span>
                                <input type="file" id="photo" name="photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-[#157e74] file:text-white
                                              hover:file:bg-[#279078]
                                              file:cursor-pointer">
                            </label>
                            <p class="mt-2 text-xs text-gray-500">
                                PNG, JPG, GIF jusqu'à 2MB
                            </p>
                            @error('photo')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if(session('status') === 'photo-updated')
                                <p class="mt-2 text-sm text-emerald-600">Photo mise à jour avec succès!</p>
                            @endif
                            @if(session('error'))
                                <p class="mt-2 text-sm text-red-600">{{ session('error') }}</p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Informations du profil -->
                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            {{ __('Nom') }}
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                      focus:border-[#157e74] focus:ring-[#157e74]">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            {{ __('Email') }}
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                      focus:border-[#157e74] focus:ring-[#157e74]">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-[#157e74] border border-transparent 
                                       rounded-lg font-semibold text-sm text-white tracking-widest 
                                       hover:bg-[#279078] focus:bg-[#279078] active:bg-[#157e74] 
                                       focus:outline-none focus:ring-2 focus:ring-[#157e74] focus:ring-offset-2 
                                       transition ease-in-out duration-150">
                            {{ __('Enregistrer') }}
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p class="text-sm text-gray-600">
                                {{ __('Enregistré.') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow-lg sm:rounded-xl">
            <div class="max-w-xl mx-auto">
                <header class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ __('Mettre à jour le mot de passe') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">
                            {{ __('Mot de passe actuel') }}
                        </label>
                        <input type="password" name="current_password" id="current_password"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                      focus:border-[#157e74] focus:ring-[#157e74]">
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            {{ __('Nouveau mot de passe') }}
                        </label>
                        <input type="password" name="password" id="password"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                      focus:border-[#157e74] focus:ring-[#157e74]">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            {{ __('Confirmer le mot de passe') }}
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                      focus:border-[#157e74] focus:ring-[#157e74]">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-[#157e74] border border-transparent 
                                       rounded-lg font-semibold text-sm text-white tracking-widest 
                                       hover:bg-[#279078] focus:bg-[#279078] active:bg-[#157e74] 
                                       focus:outline-none focus:ring-2 focus:ring-[#157e74] focus:ring-offset-2 
                                       transition ease-in-out duration-150">
                            {{ __('Enregistrer') }}
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-gray-600">
                                {{ __('Enregistré.') }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Supprimer le compte') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.') }}
                        </p>
                    </header>

                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    >{{ __('Supprimer le compte') }}</x-danger-button>

                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
                            </p>

                            <div class="mt-6">
                                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                                <x-text-input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="mt-1 block w-3/4"
                                    placeholder="{{ __('Mot de passe') }}"
                                />

                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Annuler') }}
                                </x-secondary-button>

                                <x-danger-button class="ml-3">
                                    {{ __('Supprimer le compte') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </section>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        console.log('Fichier sélectionné:', file.name, 'Type:', file.type, 'Taille:', file.size);
        
        // Prévisualisation de l'image
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log('Image chargée en prévisualisation');
            const previewPhoto = document.getElementById('preview-photo');
            if (previewPhoto) {
                previewPhoto.src = e.target.result;
            } else {
                console.log('Création d\'un nouvel élément img');
                const imgContainer = document.querySelector('.relative.h-24.w-24');
                const newImg = document.createElement('img');
                newImg.id = 'preview-photo';
                newImg.src = e.target.result;
                newImg.alt = '{{ auth()->user()->name }}';
                newImg.className = 'h-24 w-24 object-cover rounded-full border-4 border-white shadow-lg';
                imgContainer.innerHTML = '';
                imgContainer.appendChild(newImg);
            }
        }
        reader.readAsDataURL(file);
        
        // Soumission automatique du formulaire
        console.log('Soumission du formulaire...');
        document.getElementById('profile-photo-form').submit();
    }
});

// Vérifier l'état actuel de l'image
window.addEventListener('load', function() {
    const currentPhoto = document.getElementById('preview-photo');
    if (currentPhoto) {
        console.log('URL actuelle de la photo:', currentPhoto.src);
        currentPhoto.addEventListener('error', function() {
            console.log('Erreur de chargement de l\'image');
        });
    }
});
</script>
@endpush
@endsection 
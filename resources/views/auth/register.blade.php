@extends('layouts.guest')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#157e74]/10 via-[#a3cca8]/5 to-[#279078]/10">
    <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-[#a3cca8]/20">
        <h2 class="text-3xl font-extrabold text-[#157e74] text-center mb-8">{{ __('Créez votre compte') }}</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border-l-4 border-red-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <!-- Photo de profil -->
            <div class="flex flex-col items-center mb-8">
                <div class="relative">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-[#157e74]/10 shadow-lg group hover:border-[#157e74]/30 transition-all duration-200">
                        <img id="preview_photo" src="{{ asset('images/default-avatar.png') }}" 
                             alt="Photo de profil" 
                             class="w-full h-full object-cover group-hover:opacity-75 transition-opacity duration-200">
                    </div>
                    <label class="absolute bottom-0 right-0 bg-gradient-to-r from-[#157e74] to-[#279078] text-white p-3 rounded-full cursor-pointer hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <input type="file" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </label>
                </div>
                <p class="mt-3 text-sm text-[#6dbaaf]">Ajoutez une photo de profil</p>
                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-[#157e74]">Nom complet</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="pl-10 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-[#157e74]">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="pl-10 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-[#157e74]">Mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                           class="pl-10 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-[#157e74]">Confirmer le mot de passe</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="pl-10 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" 
                        class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-[#157e74] to-[#279078] hover:from-[#279078] hover:to-[#157e74] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    {{ __('Créer mon compte') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <span class="text-[#6dbaaf]">{{ __('Déjà inscrit ?') }}</span>
                <a class="ml-1 font-medium text-[#157e74] hover:text-[#279078] transition-colors duration-200" href="{{ route('login') }}">
                    {{ __('Connectez-vous') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    input[type="text"], input[type="email"], input[type="password"] {
        @apply bg-white;
    }
    input[type="text"]::placeholder, input[type="email"]::placeholder, input[type="password"]::placeholder {
        @apply text-[#6dbaaf]/60;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('preview_photo').src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush 
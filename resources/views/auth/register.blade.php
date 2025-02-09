@extends('layouts.guest')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10">
    <div class="mb-8">
        <a href="/" class="flex flex-col items-center">
            <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER" class="h-16 w-auto mb-4">
        </a>
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
        <h2 class="text-2xl font-extrabold text-[#157e74] text-center mb-8">{{ __('Créez votre compte') }}</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-400">
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
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-[#157e74]/10">
                        <img id="preview_photo" src="{{ asset('images/default-avatar.png') }}" 
                             alt="Photo de profil" 
                             class="w-full h-full object-cover">
                    </div>
                    <label class="absolute bottom-0 right-0 bg-[#157e74] text-white p-2 rounded-full cursor-pointer hover:bg-[#279078] focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <input type="file" name="profile_photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </label>
                </div>
                <p class="mt-2 text-sm text-[#6dbaaf]">Ajoutez une photo de profil</p>
                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-[#157e74]">Nom complet</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#157e74]">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-[#157e74]">Mot de passe</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
            </div>

            <!-- Confirmation du mot de passe -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[#157e74]">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                <a class="text-sm text-[#6dbaaf] hover:text-[#279078] transition-colors duration-200" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <button type="submit" 
                        class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5">
                    {{ __('Créer mon compte') }}
                </button>
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
@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#157e74]/10 via-[#a3cca8]/5 to-[#279078]/10">
    <div class="mb-8 transform hover:scale-105 transition-transform duration-300">
        <a href="/" class="flex flex-col items-center">
            <div class="bg-white p-4 rounded-2xl shadow-lg">
                <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER" class="h-16 w-auto">
            </div>
        </a>
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-2xl border border-[#a3cca8]/20">
        <h2 class="text-3xl font-extrabold text-[#157e74] text-center mb-8">{{ __('Bienvenue') }}</h2>
        
        @if (session('status'))
            <div class="mb-6 p-4 rounded-xl bg-[#a3cca8]/20 text-[#157e74] text-sm font-medium border border-[#a3cca8]/30">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-[#157e74]">
                    {{ __('Email') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="pl-10 mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-[#157e74]">
                    {{ __('Mot de passe') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-[#6dbaaf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required
                        class="pl-10 mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                </div>
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" 
                        class="rounded border-[#a3cca8] text-[#157e74] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                    <span class="ml-2 text-sm text-[#6dbaaf]">{{ __('Se souvenir de moi') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-[#157e74] hover:text-[#279078] transition-colors duration-200" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
            </div>

            <div class="pt-6">
                <button type="submit" 
                    class="w-full flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-[#157e74] to-[#279078] hover:from-[#279078] hover:to-[#157e74] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Se connecter') }}
                </button>
            </div>

            <div class="mt-6 text-center">
                <span class="text-[#6dbaaf]">{{ __('Pas encore de compte ?') }}</span>
                <a class="ml-1 font-medium text-[#157e74] hover:text-[#279078] transition-colors duration-200" href="{{ route('register') }}">
                    {{ __('Inscrivez-vous') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    input[type="email"], input[type="password"] {
        @apply bg-white;
    }
    input[type="email"]::placeholder, input[type="password"]::placeholder {
        @apply text-[#6dbaaf]/60;
    }
</style>
@endpush 
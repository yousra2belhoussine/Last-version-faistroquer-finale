@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#157e74]/10 to-[#a3cca8]/10">
    <div class="mb-8">
        <a href="/" class="flex flex-col items-center">
            <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER" class="h-16 w-auto mb-4">
        </a>
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
        <h2 class="text-2xl font-extrabold text-[#157e74] text-center mb-8">{{ __('Connexion') }}</h2>
        
        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg bg-[#a3cca8]/20 text-[#157e74] text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-[#157e74]">
                    {{ __('Email') }}
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-[#157e74]">
                    {{ __('Mot de passe') }}
                </label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-xl border-[#a3cca8] shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74]/20 transition-colors duration-200">
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

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                <a class="text-sm text-[#6dbaaf] hover:text-[#279078] transition-colors duration-200" href="{{ route('register') }}">
                    {{ __('Pas encore de compte ?') }}
                </a>

                <button type="submit" 
                    class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74] transform transition-all duration-200 hover:-translate-y-0.5">
                    {{ __('Se connecter') }}
                </button>
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
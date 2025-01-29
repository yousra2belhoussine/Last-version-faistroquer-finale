@extends('layouts.admin')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <img src="{{ asset('images/logo-faistroquerfr.svg') }}" alt="FAISTROQUER Logo" class="h-12 w-auto mx-auto mb-4">
            <h2 class="text-2xl font-bold text-[#157e74]">Administration FAISTROQUER</h2>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]" 
                    required autofocus>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]" 
                    required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" 
                        class="rounded border-gray-300 text-[#157e74] focus:ring-[#157e74]">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Se souvenir de moi</label>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#157e74] hover:bg-[#1a9085] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                    Se connecter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
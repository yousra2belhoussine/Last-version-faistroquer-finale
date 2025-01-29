@extends('layouts.guest')

@section('content') 
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-6">{{ __('Reset Password') }}</h2>
        
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <x-input
                    type="email"
                    name="email"
                    label="{{ __('Email') }}"
                    :value="old('email', $email)"
                    required
                    autofocus
                />
            </div>

            <div class="mb-4">
                <x-input
                    type="password"
                    name="password"
                    label="{{ __('New Password') }}"
                    required
                />
            </div>

            <div class="mb-4">
                <x-input
                    type="password"
                    name="password_confirmation"
                    label="{{ __('Confirm New Password') }}"
                    required
                />
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
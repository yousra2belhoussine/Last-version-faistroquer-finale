@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Informations du profil') }}
                </h2>

                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="name" :value="__('Nom')" />
                        <p class="mt-1 text-sm text-gray-600">{{ $user->name }}</p>
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <p class="mt-1 text-sm text-gray-600">{{ $user->email }}</p>
                    </div>

                    <div>
                        <x-input-label for="created_at" :value="__('Membre depuis')" />
                        <p class="mt-1 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-[#157e74] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#279078] focus:bg-[#279078] active:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-[#3aa17d] focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Modifier le profil') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
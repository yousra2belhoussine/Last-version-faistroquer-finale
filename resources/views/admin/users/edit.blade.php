<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier l\'utilisateur') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors duration-200">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name', $user->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $user->email) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label for="is_admin" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select name="is_admin" 
                                    id="is_admin" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring focus:ring-[#157e74] focus:ring-opacity-50">
                                <option value="0" {{ old('is_admin', $user->is_admin) ? '' : 'selected' }}>Utilisateur</option>
                                <option value="1" {{ old('is_admin', $user->is_admin) ? 'selected' : '' }}>Administrateur</option>
                            </select>
                            @error('is_admin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.users.index') }}" 
                               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#157e74] hover:bg-[#279078] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#157e74]">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 
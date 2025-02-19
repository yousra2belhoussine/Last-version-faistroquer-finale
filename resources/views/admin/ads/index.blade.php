<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des annonces') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Titre</th>
                                    <th scope="col" class="px-6 py-3">Utilisateur</th>
                                    <th scope="col" class="px-6 py-3">Statut</th>
                                    <th scope="col" class="px-6 py-3">Date de création</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ads as $ad)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $ad->title }}</td>
                                        <td class="px-6 py-4">{{ $ad->user->name }}</td>
                                        <td class="px-6 py-4">{{ $ad->status }}</td>
                                        <td class="px-6 py-4">{{ $ad->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.ads.show', $ad) }}" class="text-blue-600 hover:underline mr-3">Voir</a>
                                            <a href="{{ route('admin.ads.edit', $ad) }}" class="text-green-600 hover:underline mr-3">Modifier</a>
                                            <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $ads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
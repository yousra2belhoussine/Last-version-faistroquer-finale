@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tableau de bord administrateur</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Statistiques des utilisateurs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Utilisateurs</h2>
            <div class="text-3xl font-bold">{{ $users['total'] ?? 0 }}</div>
            <p class="text-gray-600">Total des utilisateurs</p>
        </div>

        <!-- Statistiques des annonces -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Annonces</h2>
            <div class="text-3xl font-bold">{{ $ads['total'] ?? 0 }}</div>
            <p class="text-gray-600">Total des annonces</p>
        </div>

        <!-- Statistiques des échanges -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Échanges</h2>
            <div class="text-3xl font-bold">{{ $exchanges['total'] ?? 0 }}</div>
            <p class="text-gray-600">Total des échanges</p>
        </div>

        <!-- Statistiques des rapports -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Rapports</h2>
            <div class="text-3xl font-bold">{{ $reports['total'] ?? 0 }}</div>
            <p class="text-gray-600">Total des rapports</p>
        </div>
    </div>
</div>
@endsection 
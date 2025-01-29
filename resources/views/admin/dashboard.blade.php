@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Période de filtrage -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-3xl font-semibold text-gray-900">Tableau de bord</h1>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <select id="period" name="period" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="all" @if($period === 'all') selected @endif>Tout</option>
                        <option value="today" @if($period === 'today') selected @endif>Aujourd'hui</option>
                        <option value="week" @if($period === 'week') selected @endif>7 derniers jours</option>
                        <option value="month" @if($period === 'month') selected @endif>30 derniers jours</option>
                        <option value="quarter" @if($period === 'quarter') selected @endif>90 derniers jours</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Statistiques générales -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Utilisateurs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Utilisateurs</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $statistics['total_users']['all'] }}</div>
                                    <div class="ml-2 flex items-baseline text-sm font-semibold">
                                        <span class="text-gray-500">
                                            ({{ $statistics['total_users']['particular'] }} particuliers, {{ $statistics['total_users']['professional'] }} pros)
                                        </span>
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Annonces -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Annonces</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $statistics['total_ads'] }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Transactions</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $statistics['total_transactions'] }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Graphique des annonces -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Évolution des annonces</h3>
                    <div class="mt-2">
                        <canvas id="adsChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>

            <!-- Graphique des transactions -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Évolution des transactions</h3>
                    <div class="mt-2">
                        <canvas id="transactionsChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes et notifications -->
        <div class="mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Alertes et notifications</h3>
                    <div class="mt-4">
                        <div class="space-y-4">
                            @if($statistics['pending_reports'] > 0)
                                <div class="flex items-center justify-between bg-yellow-50 p-4 rounded-md">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span class="ml-3 text-sm font-medium text-yellow-800">
                                            {{ $statistics['pending_reports'] }} signalement(s) en attente
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.reports.index') }}" class="text-sm font-medium text-yellow-800 hover:text-yellow-700">
                                        Voir les signalements
                                    </a>
                                </div>
                            @endif

                            @if($statistics['new_professional_validations'] > 0)
                                <div class="flex items-center justify-between bg-blue-50 p-4 rounded-md">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="ml-3 text-sm font-medium text-blue-800">
                                            {{ $statistics['new_professional_validations'] }} compte(s) professionnel(s) en attente de validation
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.users.index', ['type' => 'professional', 'status' => 'pending']) }}" class="text-sm font-medium text-blue-800 hover:text-blue-700">
                                        Voir les comptes
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration des graphiques
    const adsData = @json($graphData['ads']);
    const transactionsData = @json($graphData['transactions']);

    // Graphique des annonces
    new Chart(document.getElementById('adsChart'), {
        type: 'line',
        data: {
            labels: adsData.map(item => item.period),
            datasets: [{
                label: 'Annonces',
                data: adsData.map(item => item.count),
                borderColor: 'rgb(79, 70, 229)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Graphique des transactions
    new Chart(document.getElementById('transactionsChart'), {
        type: 'line',
        data: {
            labels: transactionsData.map(item => item.period),
            datasets: [{
                label: 'Transactions',
                data: transactionsData.map(item => item.count),
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Gestion du changement de période
    document.getElementById('period').addEventListener('change', function() {
        window.location.href = `{{ route('admin.dashboard') }}?period=${this.value}`;
    });
});
</script>
@endpush
@endsection 
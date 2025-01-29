@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec sélecteur de période -->
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-900">Tableau de bord</h2>
            <div class="flex items-center space-x-4">
                <label for="period" class="text-sm font-medium text-gray-700">Période :</label>
                <select id="period" name="period" class="rounded-md border-gray-300 shadow-sm focus:border-[#157e74] focus:ring-[#157e74]">
                    <option value="today" {{ $period === 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>7 derniers jours</option>
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>30 derniers jours</option>
                    <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>90 derniers jours</option>
                    <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Tout</option>
                </select>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Utilisateurs -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Utilisateurs</dt>
                                <dd class="mt-1">
                                    <div class="text-lg font-semibold text-gray-900">{{ $stats['total_users']['count'] }}</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $stats['total_users']['particular'] }} particuliers, 
                                        {{ $stats['total_users']['professional'] }} professionnels
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Annonces -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Annonces</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $stats['total_ads'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Échanges -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Échanges</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $stats['total_exchanges'] }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validations en attente -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-[#157e74] rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">En attente de validation</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $stats['pending_pro_validations'] }}</dd>
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution des Annonces</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="adsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Graphique des échanges -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Évolution des Échanges</h3>
                    <div class="relative" style="height: 300px;">
                        <canvas id="exchangesChart"></canvas>
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
    const chartData = @json($charts);
    console.log('Chart Data:', chartData);

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    title: function(context) {
                        return context[0].label;
                    },
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            x: {
                display: true,
                grid: {
                    display: false
                },
                ticks: {
                    maxRotation: 45,
                    minRotation: 45
                }
            },
            y: {
                display: true,
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    precision: 0
                }
            }
        },
        elements: {
            line: {
                tension: 0.4,
                borderWidth: 2,
                fill: true
            },
            point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 6
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    };

    // Graphique des annonces
    if (document.getElementById('adsChart')) {
        const adsChart = new Chart(document.getElementById('adsChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.ads_data.labels,
                datasets: [{
                    label: 'Annonces',
                    data: chartData.ads_data.data,
                    borderColor: '#157e74',
                    backgroundColor: 'rgba(21, 126, 116, 0.1)',
                    fill: true
                }]
            },
            options: commonOptions
        });
    }

    // Graphique des échanges
    if (document.getElementById('exchangesChart')) {
        const exchangesChart = new Chart(document.getElementById('exchangesChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.exchanges_data.labels,
                datasets: [{
                    label: 'Échanges',
                    data: chartData.exchanges_data.data,
                    borderColor: '#157e74',
                    backgroundColor: 'rgba(21, 126, 116, 0.1)',
                    fill: true
                }]
            },
            options: commonOptions
        });
    }

    // Gestion du changement de période
    const periodSelect = document.getElementById('period');
    if (periodSelect) {
        periodSelect.value = '{{ $period }}';
        periodSelect.addEventListener('change', function(e) {
            window.location.href = `{{ route('admin.dashboard') }}?period=${e.target.value}`;
        });
    }
});
</script>
@endpush
@endsection 
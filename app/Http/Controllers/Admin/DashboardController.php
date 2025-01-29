<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ad;
use App\Models\Exchange;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer la période sélectionnée
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);

        // Statistiques globales
        $stats = [
            'total_users' => [
                'count' => User::count(),
                'particular' => User::where('type', 'particular')->count(),
                'professional' => User::where('type', 'professional')->count()
            ],
            'total_ads' => Ad::count(),
            'total_exchanges' => Exchange::count(),
            'pending_pro_validations' => User::where('type', 'professional')
                                           ->where('is_validated', false)
                                           ->count(),
        ];

        // Données pour les graphiques
        $charts = $this->getChartsData($startDate);

        // Debug des données
        \Log::info('Chart Data:', $charts);

        // Activités récentes
        $recent_activities = [
            'new_users' => User::latest()->take(5)->get(),
            'new_ads' => Ad::with('user')->latest()->take(5)->get(),
            'new_exchanges' => Exchange::with(['ad', 'user'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard.index', compact('stats', 'charts', 'recent_activities', 'period'));
    }

    private function getStartDate($period)
    {
        return match($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'quarter' => Carbon::now()->subDays(90),
            'all' => Carbon::createFromYear(2000),
            default => Carbon::now()->subDays(30),
        };
    }

    private function getChartsData($startDate)
    {
        try {
            // Données pour le graphique des annonces
            $adsData = Ad::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            // Données pour le graphique des échanges
            $exchangesData = Exchange::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                ->where('created_at', '>=', $startDate)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            // Générer la plage de dates
            $dates = $this->generateDateRange($startDate, Carbon::now());
            
            // Formater les données
            $adsDataFormatted = $this->formatDataForChart($dates, $adsData);
            $exchangesDataFormatted = $this->formatDataForChart($dates, $exchangesData);

            // Formater les dates pour l'affichage
            $formattedLabels = array_map(function($date) {
                return Carbon::parse($date)->format('d/m/Y');
            }, array_keys($adsDataFormatted));

            // Debug
            \Log::info('Formatted Data:', [
                'labels' => $formattedLabels,
                'ads_data' => array_values($adsDataFormatted),
                'exchanges_data' => array_values($exchangesDataFormatted)
            ]);

            return [
                'ads_data' => [
                    'labels' => $formattedLabels,
                    'data' => array_values($adsDataFormatted)
                ],
                'exchanges_data' => [
                    'labels' => $formattedLabels,
                    'data' => array_values($exchangesDataFormatted)
                ]
            ];
        } catch (\Exception $e) {
            \Log::error('Error in getChartsData: ' . $e->getMessage());
            return [
                'ads_data' => ['labels' => [], 'data' => []],
                'exchanges_data' => ['labels' => [], 'data' => []]
            ];
        }
    }

    private function generateDateRange($startDate, $endDate)
    {
        $dates = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $dates[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        return $dates;
    }

    private function formatDataForChart($dates, $data)
    {
        $formattedData = $dates;
        
        foreach ($data as $item) {
            $date = $item->date instanceof Carbon ? $item->date->format('Y-m-d') : $item->date;
            if (isset($formattedData[$date])) {
                $formattedData[$date] = (int)$item->count;
            }
        }
        
        return $formattedData;
    }
} 
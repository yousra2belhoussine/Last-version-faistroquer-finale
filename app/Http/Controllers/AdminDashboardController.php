<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Proposition;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'all');
        $query = match ($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'quarter' => Carbon::now()->subDays(90),
            default => null
        };

        // Base queries
        $usersQuery = User::query();
        $adsQuery = Ad::query();
        $transactionsQuery = Transaction::query();
        $propositionsQuery = Proposition::query();
        $reportsQuery = Report::query();

        // Apply date filter if period is selected
        if ($query) {
            $usersQuery->where('created_at', '>=', $query);
            $adsQuery->where('created_at', '>=', $query);
            $transactionsQuery->where('created_at', '>=', $query);
            $propositionsQuery->where('created_at', '>=', $query);
            $reportsQuery->where('created_at', '>=', $query);
        }

        // Get statistics
        $statistics = [
            'total_users' => [
                'all' => $usersQuery->count(),
                'particular' => $usersQuery->clone()->where('type', 'particular')->count(),
                'professional' => $usersQuery->clone()->where('type', 'professional')->count(),
            ],
            'total_ads' => $adsQuery->count(),
            'total_transactions' => $transactionsQuery->count(),
            'total_propositions' => $propositionsQuery->count(),
            'pending_reports' => $reportsQuery->where('status', 'pending')->count(),
            'new_professional_validations' => $usersQuery->clone()
                ->where('type', 'professional')
                ->where('is_validated', false)
                ->count(),
        ];

        // Get data for graphs
        $graphData = [
            'ads' => $this->getGraphData($adsQuery->clone(), $period),
            'transactions' => $this->getGraphData($transactionsQuery->clone(), $period),
            'propositions' => $this->getGraphData($propositionsQuery->clone(), $period),
        ];

        return Inertia::render('Admin/Dashboard', [
            'statistics' => $statistics,
            'graphData' => $graphData,
            'period' => $period,
        ]);
    }

    /**
     * Get graph data based on period
     */
    private function getGraphData($query, string $period)
    {
        $grouping = match ($period) {
            'today' => 'hour',
            'week' => 'day',
            'month' => 'day',
            'quarter' => 'week',
            default => 'month'
        };

        return $query->selectRaw(
            match ($grouping) {
                'hour' => 'HOUR(created_at) as period',
                'day' => 'DATE(created_at) as period',
                'week' => 'YEARWEEK(created_at) as period',
                'month' => 'DATE_FORMAT(created_at, "%Y-%m") as period'
            }
        )
        ->selectRaw('COUNT(*) as count')
        ->groupBy('period')
        ->orderBy('period')
        ->get();
    }
} 
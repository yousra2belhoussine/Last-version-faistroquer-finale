<?php

namespace App\Http\Controllers\Admin\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

trait AdminControllerTrait
{
    /**
     * Vérifie si l'utilisateur a les permissions nécessaires
     */
    protected function checkPermission($permission)
    {
        if (!auth()->user()->can($permission)) {
            abort(403, 'Action non autorisée.');
        }
    }

    /**
     * Prépare les données pour le dashboard
     */
    protected function prepareDashboardData()
    {
        return [
            'totalUsers' => \App\Models\User::count(),
            'totalAds' => \App\Models\Ad::count(),
            'totalArticles' => \App\Models\Article::count(),
            'recentActivities' => $this->getRecentActivities()
        ];
    }

    /**
     * Récupère les activités récentes
     */
    protected function getRecentActivities()
    {
        return \App\Models\Activity::latest()->take(10)->get();
    }

    /**
     * Formate le message de réponse JSON
     */
    protected function respondWithSuccess($message, $data = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Formate le message d'erreur JSON
     */
    protected function respondWithError($message, $errors = [], $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    /**
     * Récupère les données en cache ou exécute la callback
     */
    protected function remember(string $key, \Closure $callback, $ttl = 3600)
    {
        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Nettoie le cache lié à une entité
     */
    protected function clearEntityCache(string $entity): void
    {
        Cache::tags([$entity])->flush();
    }

    /**
     * Log une action administrative
     */
    protected function logAdminAction(string $action, array $data = []): void
    {
        activity()
            ->causedBy(auth()->user())
            ->withProperties($data)
            ->log($action);
    }
} 
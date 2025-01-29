<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Routing\Controller as BaseController;

class SearchSuggestionController extends BaseController
{
    public function suggest(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'popular' => $this->getPopularSearches(),
                'recent' => $this->getRecentSearches($request),
            ]);
        }

        return response()->json([
            'ads' => $this->searchAds($query),
            'users' => $this->searchUsers($query),
            'similar' => $this->getSimilarSearches($query),
            'recent' => $this->getRecentSearches($request),
        ]);
    }

    private function searchAds($query)
    {
        return Ad::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($ad) {
                return [
                    'id' => $ad->id,
                    'title' => $ad->title,
                    'type' => 'ad',
                    'url' => route('ads.show', $ad),
                ];
            });
    }

    private function searchUsers($query)
    {
        return User::where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'type' => 'user',
                    'url' => route('users.show', $user),
                ];
            });
    }

    private function getPopularSearches()
    {
        return Cache::remember('popular_searches', 3600, function () {
            return Ad::select('title')
                ->orderBy('views', 'desc')
                ->limit(5)
                ->get()
                ->pluck('title');
        });
    }

    private function getSimilarSearches($query)
    {
        return Ad::where('title', 'like', "%{$query}%")
            ->select('title')
            ->distinct()
            ->limit(3)
            ->get()
            ->pluck('title');
    }

    private function getRecentSearches(Request $request)
    {
        $searches = $request->session()->get('recent_searches', []);
        return array_slice($searches, 0, 3);
    }

    public function saveSearch(Request $request)
    {
        $query = $request->get('q');
        if (!$query) return;

        $searches = $request->session()->get('recent_searches', []);
        
        // Add new search to the beginning and remove duplicates
        array_unshift($searches, $query);
        $searches = array_unique($searches);
        
        // Keep only the last 10 searches
        $searches = array_slice($searches, 0, 10);
        
        $request->session()->put('recent_searches', $searches);
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CredibilityController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $credibilityScore = $user->calculateCredibilityScore();
        $badges = $user->badges;
        $transactions = $user->transactions()->latest()->take(5)->get();
        $positiveReviews = $user->receivedReviews()->where('rating', '>=', 4)->count();

        return view('profile.credibility', [
            'user' => $user,
            'credibilityScore' => $credibilityScore,
            'badges' => $badges,
            'transactions' => $transactions,
            'positiveReviews' => $positiveReviews,
        ]);
    }

    public function improve()
    {
        $user = auth()->user();
        $missingBadges = $user->getMissingBadges();
        $credibilityTips = $user->getCredibilityTips();

        return view('profile.credibility.improve', [
            'user' => $user,
            'missingBadges' => $missingBadges,
            'credibilityTips' => $credibilityTips,
        ]);
    }
} 
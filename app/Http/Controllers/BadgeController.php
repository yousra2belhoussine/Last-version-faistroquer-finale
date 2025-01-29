<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display the user's badges.
     */
    public function index()
    {
        $user = auth()->user();
        $badges = $user->badges()->with('category')->get();
        $availableBadges = Badge::whereNotIn('id', $badges->pluck('id'))->get();

        return view('profile.badges', [
            'user' => $user,
            'badges' => $badges,
            'availableBadges' => $availableBadges
        ]);
    }
} 
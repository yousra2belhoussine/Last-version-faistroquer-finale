<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Article;
use App\Models\Ad;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $articlesCount = Article::count();
        $adsCount = Ad::count();

        return view('admin.dashboard', compact('usersCount', 'articlesCount', 'adsCount'));
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Exchange;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->user()->is_admin) {
            return redirect('/');
        }

        $data = [
            'users' => [
                'total' => User::count()
            ],
            'ads' => [
                'total' => Ad::count()
            ],
            'articles' => [
                'total' => Article::count()
            ],
            'exchanges' => [
                'total' => Exchange::count()
            ]
        ];

        return view('admin.dashboard', $data);
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.articles.index', compact('articles'));
    }

    public function approve(Article $article)
    {
        $article->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Article approuvé avec succès!');
    }

    public function reject(Article $article)
    {
        $article->update([
            'is_published' => false,
            'published_at' => null,
        ]);

        return redirect()->back()->with('success', 'Article rejeté avec succès!');
    }
} 
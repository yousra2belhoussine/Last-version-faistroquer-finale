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
    }

    private function checkAdmin()
    {
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }
    }

    /**
     * Display a listing of the articles.
     */
    public function index()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $articles = Article::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        $pendingCount = Article::where('status', 'pending')->count();
        $approvedCount = Article::where('status', 'approved')->count();
        $rejectedCount = Article::where('status', 'rejected')->count();

        return view('admin.articles.index', compact(
            'articles',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $article = Article::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        $article->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id']
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('articles', 'public');
                $article->images()->create([
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès.');
    }

    public function approve(Article $article)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $article->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'L\'article a été approuvé avec succès.');
    }

    public function reject(Article $article)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $article->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'L\'article a été refusé.');
    }
} 
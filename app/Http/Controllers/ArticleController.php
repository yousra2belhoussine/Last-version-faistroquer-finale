<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest('created_at')->paginate(12);
        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        if (!$article->is_published && (!auth()->check() || auth()->id() !== $article->user_id)) {
            abort(404);
        }

        if ($article->published_at) {
            $article->formatted_date = $article->published_at->format('d M Y');
        }

        return view('articles.show', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'category' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean|nullable',
        ]);

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $article = auth()->user()->articles()->create($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article créé avec succès!');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'category' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $path = $request->file('featured_image')->store('articles', 'public');
            $validated['featured_image'] = $path;
        }

        $validated['slug'] = Str::slug($validated['title']);
        if (!$article->is_published && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article mis à jour avec succès!');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article supprimé avec succès!');
    }
} 
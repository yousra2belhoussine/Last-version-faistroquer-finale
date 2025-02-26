<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        // Ne récupérer que les articles validés pour les utilisateurs normaux
        $articles = Article::where('status', 'approved')
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        // Vérifier si l'article est approuvé ou si l'utilisateur est l'auteur ou un admin
        if ($article->status !== 'approved' && 
            auth()->id() !== $article->user_id && 
            !auth()->user()?->is_admin) {
            abort(404);
        }

        // Charger les relations nécessaires
        $article->load(['category', 'user', 'images']);

        if ($article->published_at) {
            $article->formatted_date = $article->published_at->format('d M Y');
        }

        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Créer l'article avec le statut "pending"
        $article = Article::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'status' => 'pending' // En attente de validation
        ]);

        // Gérer les images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Générer un nom unique pour l'image
                $filename = uniqid('article_') . '.' . $image->getClientOriginalExtension();
                // Sauvegarder l'image dans le dossier public/storage/articles
                $path = $image->storeAs('articles', $filename, 'public');
                // Créer l'enregistrement dans la base de données
                $article->images()->create([
                    'path' => $path,
                    'title' => $image->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('articles.index')
            ->with('success', 'Votre article a été créé et est en attente de validation par un administrateur.');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        
        // Récupérer toutes les catégories
        $categories = Category::all();
        
        // Charger les relations nécessaires
        $article->load(['category', 'images']);
        
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable',
            'featured_image' => 'nullable|image|max:2048'
        ]);

        // Gérer l'image mise en avant si elle est fournie
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        // Gérer le statut de publication
        $validated['is_published'] = $request->has('is_published');
        
        // Mettre à jour la date de publication si l'article est publié pour la première fois
        if (!$article->is_published && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        $validated['slug'] = Str::slug($validated['title']);
        
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

    public function myArticles()
    {
        $articles = Article::where('user_id', auth()->id())
            ->with(['category', 'images'])
            ->latest()
            ->paginate(12);

        return view('articles.my-articles', compact('articles'));
    }
} 
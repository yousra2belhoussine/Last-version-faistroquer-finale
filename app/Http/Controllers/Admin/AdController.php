<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkAdmin()
    {
        if (!auth()->user()->is_admin) {
            return redirect('/')->with('error', 'Accès non autorisé.');
        }
    }

    public function index()
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $ads = Ad::with(['user', 'category'])
               ->latest()
               ->paginate(10);

        return view('admin.ads.index', compact('ads'));
    }

    public function show(Ad $ad)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $ad->load(['user', 'category', 'images']);
        
        if (!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
        }
        
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $categories = Category::all();
        return view('admin.ads.edit', compact('ad', 'categories'));
    }

    public function update(Request $request, Ad $ad)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|string|in:new,like_new,good,fair,poor',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Mise à jour des informations de base de l'annonce
        $ad->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'condition' => $validated['condition'],
        ]);

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            $order = $ad->images()->max('order') ?? 0;
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('ads', 'public');
                $order++;
                
                $ad->images()->create([
                    'path' => $path,
                    'order' => $order,
                    'is_primary' => $order === 1
                ]);
            }
        }

        return redirect()->route('admin.ads.show', $ad)
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    public function destroy(Ad $ad)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        foreach ($ad->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $ad->delete();

        return redirect()->route('admin.ads.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }

    public function deleteImage($imageId)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $image = Image::findOrFail($imageId);
        
        if ($image->ad) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 403);
    }

    public function validateAd(Request $request, Ad $ad)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $ad->update(['status' => 'active']); 

        return redirect()->back()->with('success', 'Annonce validée avec succès');
    }

    public function reject(Ad $ad, Request $request)
    {
        if ($response = $this->checkAdmin()) {
            return $response;
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $ad->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Annonce rejetée avec succès');
    }
} 
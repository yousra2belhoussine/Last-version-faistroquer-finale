<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::with(['user', 'category']);

        // Filtrage par catégorie
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtrage par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtrage par région
        if ($request->has('region')) {
            $query->where('region', $request->region);
        }

        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Recherche par titre
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $ads = $query->paginate(20);
        return view('admin.ads.index', compact('ads'));
    }

    public function show(Ad $ad)
    {
        $ad->load(['user', 'category', 'exchanges']);
        return view('admin.ads.show', compact('ad'));
    }

    public function edit(Ad $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:good,service',
            'region' => 'required|string',
            'status' => 'required|in:active,pending,rejected,paused'
        ]);

        $ad->update($validated);

        return redirect()->route('admin.ads.show', $ad)
            ->with('success', 'Annonce mise à jour avec succès');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('admin.ads.index')
            ->with('success', 'Annonce supprimée avec succès');
    }

    // public function validate(Ad $ad)
    // {
    //     $ad->update(['status' => 'active']); 
    //     return redirect()->back()->with('success', 'Annonce validée avec succès');
    // }
    public function validateAd(Request $request, Ad $ad)
    {
        // Validation de la requête
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        // Mise à jour du statut de l'annonce
        $ad->update(['status' => 'active']); 


        return redirect()->back()->with('success', 'Annonce validée avec succès');
    
    }


    public function reject(Ad $ad, Request $request)
    {
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
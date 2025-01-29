<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminAdController extends Controller
{
    /**
     * Display a listing of ads.
     */
    public function index(Request $request)
    {
        $query = Ad::query()
            ->with(['user', 'category', 'region'])
            ->withCount(['propositions']);

        // Apply filters
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('region')) {
            $query->where('region_id', $request->region);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $ads = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Ads/Index', [
            'ads' => $ads,
            'filters' => $request->only(['category', 'region', 'type', 'status', 'search']),
        ]);
    }

    /**
     * Display the specified ad.
     */
    public function show(Ad $ad)
    {
        $ad->load([
            'user',
            'category',
            'region',
            'images',
            'propositions.user',
        ]);

        return Inertia::render('Admin/Ads/Show', [
            'ad' => $ad,
        ]);
    }

    /**
     * Update the specified ad.
     */
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'required|exists:regions,id',
            'type' => 'required|in:offer,request',
            'status' => 'required|in:pending,active,paused,closed',
        ]);

        $ad->update($validated);

        return redirect()->route('admin.ads.show', $ad)
            ->with('success', 'Ad updated successfully.');
    }

    /**
     * Toggle the status of an ad.
     */
    public function toggleStatus(Ad $ad)
    {
        $newStatus = $ad->status === 'active' ? 'paused' : 'active';
        
        $ad->update(['status' => $newStatus]);

        return back()->with('success', 'Ad status updated successfully.');
    }

    /**
     * Remove the specified ad.
     */
    public function destroy(Ad $ad)
    {
        // Delete associated images first
        foreach ($ad->images as $image) {
            Storage::delete($image->path);
            $image->delete();
        }

        // Delete the ad
        $ad->delete();

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad deleted successfully.');
    }
} 
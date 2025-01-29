<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminSponsorController extends Controller
{
    /**
     * Display a listing of sponsors.
     */
    public function index(Request $request)
    {
        $query = Sponsor::query()
            ->withCount('campaigns')
            ->with(['activeCampaigns']);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $sponsors = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Sponsors/Index', [
            'sponsors' => $sponsors,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new sponsor.
     */
    public function create()
    {
        return Inertia::render('Admin/Sponsors/Create');
    }

    /**
     * Store a newly created sponsor.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'website' => 'nullable|url',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'logo' => 'required|image|max:2048', // 2MB max
        ]);

        // Store the logo
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('sponsors/logos', 'public');
            $validated['logo'] = $path;
        }

        $sponsor = Sponsor::create($validated);

        return redirect()->route('admin.sponsors.show', $sponsor)
            ->with('success', 'Sponsor created successfully.');
    }

    /**
     * Display the specified sponsor.
     */
    public function show(Sponsor $sponsor)
    {
        $sponsor->load(['campaigns' => function ($query) {
            $query->latest();
        }]);

        return Inertia::render('Admin/Sponsors/Show', [
            'sponsor' => $sponsor,
        ]);
    }

    /**
     * Show the form for editing the specified sponsor.
     */
    public function edit(Sponsor $sponsor)
    {
        return Inertia::render('Admin/Sponsors/Edit', [
            'sponsor' => $sponsor,
        ]);
    }

    /**
     * Update the specified sponsor.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'website' => 'nullable|url',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048', // 2MB max
        ]);

        // Update logo if provided
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            
            // Store new logo
            $path = $request->file('logo')->store('sponsors/logos', 'public');
            $validated['logo'] = $path;
        }

        $sponsor->update($validated);

        return redirect()->route('admin.sponsors.show', $sponsor)
            ->with('success', 'Sponsor updated successfully.');
    }

    /**
     * Remove the specified sponsor.
     */
    public function destroy(Sponsor $sponsor)
    {
        // Delete logo
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }

        // Delete sponsor and related campaigns
        $sponsor->campaigns()->delete();
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')
            ->with('success', 'Sponsor deleted successfully.');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\SponsorCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AdminSponsorCampaignController extends Controller
{
    /**
     * Display a listing of campaigns for a sponsor.
     */
    public function index(Request $request, Sponsor $sponsor)
    {
        $query = $sponsor->campaigns()
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            });

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $campaigns = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Sponsors/Campaigns/Index', [
            'sponsor' => $sponsor,
            'campaigns' => $campaigns,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create(Sponsor $sponsor)
    {
        return Inertia::render('Admin/Sponsors/Campaigns/Create', [
            'sponsor' => $sponsor,
        ]);
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:banner,popup,sidebar',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|array',
            'target_audience.*' => 'string|in:all,particular,professional',
            'target_regions' => 'nullable|array',
            'target_regions.*' => 'exists:regions,id',
            'target_categories' => 'nullable|array',
            'target_categories.*' => 'exists:categories,id',
            'media' => 'required|array',
            'media.*' => 'image|max:2048', // 2MB max
            'status' => 'required|in:draft,scheduled,active,paused,completed',
        ]);

        // Store media files
        $mediaFiles = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('sponsors/campaigns', 'public');
                $mediaFiles[] = $path;
            }
        }
        $validated['media'] = $mediaFiles;

        // Create campaign
        $campaign = $sponsor->campaigns()->create($validated);

        return redirect()->route('admin.sponsors.campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified campaign.
     */
    public function show(SponsorCampaign $campaign)
    {
        $campaign->load('sponsor');

        return Inertia::render('Admin/Sponsors/Campaigns/Show', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Show the form for editing the specified campaign.
     */
    public function edit(SponsorCampaign $campaign)
    {
        $campaign->load('sponsor');

        return Inertia::render('Admin/Sponsors/Campaigns/Edit', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * Update the specified campaign.
     */
    public function update(Request $request, SponsorCampaign $campaign)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:banner,popup,sidebar',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|array',
            'target_audience.*' => 'string|in:all,particular,professional',
            'target_regions' => 'nullable|array',
            'target_regions.*' => 'exists:regions,id',
            'target_categories' => 'nullable|array',
            'target_categories.*' => 'exists:categories,id',
            'media' => 'nullable|array',
            'media.*' => 'image|max:2048', // 2MB max
            'status' => 'required|in:draft,scheduled,active,paused,completed',
            'keep_media' => 'array',
        ]);

        // Handle media files
        $mediaFiles = [];
        
        // Keep existing media files that weren't removed
        if ($request->has('keep_media')) {
            foreach ($campaign->media as $path) {
                if (in_array($path, $request->keep_media)) {
                    $mediaFiles[] = $path;
                } else {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        // Add new media files
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('sponsors/campaigns', 'public');
                $mediaFiles[] = $path;
            }
        }
        $validated['media'] = $mediaFiles;

        // Update campaign
        $campaign->update($validated);

        return redirect()->route('admin.sponsors.campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully.');
    }

    /**
     * Toggle the campaign status between active and paused.
     */
    public function toggle(SponsorCampaign $campaign)
    {
        $newStatus = $campaign->status === 'active' ? 'paused' : 'active';
        
        $campaign->update(['status' => $newStatus]);

        return back()->with('success', 'Campaign status updated successfully.');
    }

    /**
     * Remove the specified campaign.
     */
    public function destroy(SponsorCampaign $campaign)
    {
        // Delete media files
        foreach ($campaign->media as $path) {
            Storage::disk('public')->delete($path);
        }

        // Delete campaign
        $campaign->delete();

        return redirect()->route('admin.sponsors.campaigns.index', $campaign->sponsor)
            ->with('success', 'Campaign deleted successfully.');
    }
} 
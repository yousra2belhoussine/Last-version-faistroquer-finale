<?php

namespace App\Http\Controllers;

use App\Models\Dispute;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDisputeController extends Controller
{
    /**
     * Display a listing of disputes.
     */
    public function index(Request $request)
    {
        $query = Dispute::query()
            ->with(['reporter', 'reported', 'proposition.ad'])
            ->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            });

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('reason', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $disputes = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Disputes/Index', [
            'disputes' => $disputes,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Display the specified dispute.
     */
    public function show(Dispute $dispute)
    {
        $dispute->load([
            'reporter',
            'reported',
            'proposition.ad',
            'proposition.messages',
            'adminActions',
        ]);

        return Inertia::render('Admin/Disputes/Show', [
            'dispute' => $dispute,
        ]);
    }

    /**
     * Resolve a dispute with specified action.
     */
    public function resolve(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'action' => 'required|in:restrict,suspend,investigate,close',
            'restriction_type' => 'required_if:action,restrict|in:need_approval,not_allowed',
            'restriction_duration' => 'required_if:action,restrict|integer|min:1',
            'resolution_notes' => 'required|string',
        ]);

        // Create admin action record
        $dispute->adminActions()->create([
            'admin_id' => auth()->id(),
            'action' => $validated['action'],
            'details' => [
                'restriction_type' => $validated['restriction_type'] ?? null,
                'restriction_duration' => $validated['restriction_duration'] ?? null,
                'notes' => $validated['resolution_notes'],
            ],
        ]);

        // Apply action to reported user
        switch ($validated['action']) {
            case 'restrict':
                $dispute->reported->update([
                    'is_restricted' => true,
                    'restriction_type' => $validated['restriction_type'],
                    'restriction_ends_at' => now()->addDays($validated['restriction_duration']),
                ]);
                break;
            
            case 'suspend':
                $dispute->reported->update([
                    'is_suspended' => true,
                    'suspended_at' => now(),
                ]);
                break;
            
            case 'investigate':
                $dispute->reported->update([
                    'under_investigation' => true,
                    'investigation_started_at' => now(),
                ]);
                break;
        }

        // Update dispute status
        $dispute->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);

        // Notify users
        $dispute->reporter->notify(new DisputeResolved($dispute));
        $dispute->reported->notify(new AccountActionTaken($dispute));

        return redirect()->route('admin.disputes.show', $dispute)
            ->with('success', 'Dispute resolved successfully.');
    }

    /**
     * Contact users involved in the dispute.
     */
    public function contactUsers(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'recipients' => 'required|array',
            'recipients.*' => 'required|in:reporter,reported',
        ]);

        foreach ($validated['recipients'] as $recipient) {
            $user = $recipient === 'reporter' ? $dispute->reporter : $dispute->reported;
            
            // Send message to user
            $user->notify(new DisputeMessage($dispute, $validated['message']));
        }

        return back()->with('success', 'Message sent to selected users.');
    }
} 
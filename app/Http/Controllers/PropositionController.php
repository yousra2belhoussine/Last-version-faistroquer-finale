<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PropositionController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'offer' => 'required|string', 
            'message' => 'nullable|string',
            'online_exchange' => 'boolean',
            'meeting_location' => 'required_if:online_exchange,false|nullable|string',
            'meeting_date' => 'required_if:online_exchange,false|nullable|date',
            'ad_id' => 'required|exists:ads,id',
        ]);

         // Si l'échange en ligne est coché, définissez les champs meeting_location et meeting_date à null
         if ($request->online_exchange) {
            $validated['meeting_location'] = null;
            $validated['meeting_date'] = null;
        }

        $proposition = new Proposition($validated);
        $proposition->ad_id = $ad->id;
        $proposition->user_id = Auth::id();
        $proposition->status = 'pending';
        $proposition->save();

        return redirect()->route('ads.show', $ad)
            ->with('success', __('Your proposition has been sent successfully.'));
    }

    public function accept(Proposition $proposition)
    {
        $this->authorize('update', $proposition->ad);

        $proposition->update(['status' => 'accepted']);

        return redirect()->back()
            ->with('success', __('Proposition accepted successfully.'));
    }

    public function reject(Proposition $proposition)
    {
        $this->authorize('update', $proposition->ad);

        $proposition->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', __('Proposition rejected successfully.'));
    }

    public function complete(Proposition $proposition)
    {
        $this->authorize('update', $proposition->ad);

        $proposition->update(['status' => 'completed']);

        return redirect()->back()
            ->with('success', __('Exchange marked as completed successfully.'));
    }

    public function cancel(Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        if (!$proposition->isPending() && !$proposition->isAccepted()) {
            abort(403, __('This proposition cannot be cancelled.'));
        }

        $proposition->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', __('Proposition cancelled successfully.'));
    }

    public function updateMeeting(Request $request, Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        if (!$proposition->isAccepted()) {
            abort(403, __('Meeting details can only be updated for accepted propositions.'));
        }

        $validated = $request->validate([
            'meeting_location' => 'required|string',
            'meeting_date' => 'required|date|after:now',
        ]);

        $proposition->update($validated);

        return redirect()->back()
            ->with('success', __('Meeting details updated successfully.'));
    }

    public function index()
    {
        $propositions = Proposition::with(['ad', 'user'])
            ->where(function($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereHas('ad', function($q) {
                        $q->where('user_id', Auth::id());
                    });
            })
            ->latest()
            ->paginate(10);

        return view('propositions.index', compact('propositions'));
    }

    public function show(Proposition $proposition)
    {
        if (Auth::id() !== $proposition->user_id && Auth::id() !== $proposition->ad->user_id) {
            abort(403);
        }

        $proposition->load(['ad', 'user', 'messages.user']);

        return view('propositions.show', compact('proposition'));
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminContestController extends Controller
{
    /**
     * Display a listing of contests.
     */
    public function index(Request $request)
    {
        $query = Contest::query()
            ->with(['winner'])
            ->withCount('participants');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $contests = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Contests/Index', [
            'contests' => $contests,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new contest.
     */
    public function create()
    {
        return Inertia::render('Admin/Contests/Create');
    }

    /**
     * Store a newly created contest.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'prize_description' => 'required|string',
            'rules' => 'required|string',
            'participation_criteria' => 'required|array',
            'participation_criteria.*' => 'string',
            'status' => 'required|in:draft,scheduled,active,completed',
        ]);

        $contest = Contest::create($validated);

        return redirect()->route('admin.contests.show', $contest)
            ->with('success', 'Contest created successfully.');
    }

    /**
     * Display the specified contest.
     */
    public function show(Contest $contest)
    {
        $contest->load(['winner', 'participants' => function ($query) {
            $query->withCount(['ads', 'transactions'])
                ->orderByDesc('transactions_count');
        }]);

        return Inertia::render('Admin/Contests/Show', [
            'contest' => $contest,
        ]);
    }

    /**
     * Show the form for editing the specified contest.
     */
    public function edit(Contest $contest)
    {
        return Inertia::render('Admin/Contests/Edit', [
            'contest' => $contest,
        ]);
    }

    /**
     * Update the specified contest.
     */
    public function update(Request $request, Contest $contest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'prize_description' => 'required|string',
            'rules' => 'required|string',
            'participation_criteria' => 'required|array',
            'participation_criteria.*' => 'string',
            'status' => 'required|in:draft,scheduled,active,completed',
        ]);

        $contest->update($validated);

        return redirect()->route('admin.contests.show', $contest)
            ->with('success', 'Contest updated successfully.');
    }

    /**
     * Display the current week's contest.
     */
    public function currentWeek()
    {
        $contest = Contest::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('status', 'active')
            ->with(['participants' => function ($query) {
                $query->withCount(['ads', 'transactions'])
                    ->orderByDesc('transactions_count');
            }])
            ->first();

        if (!$contest) {
            return redirect()->route('admin.contests.index')
                ->with('error', 'No active contest found for the current week.');
        }

        return Inertia::render('Admin/Contests/CurrentWeek', [
            'contest' => $contest,
        ]);
    }

    /**
     * Select a winner for the contest.
     */
    public function selectWinner(Request $request)
    {
        $validated = $request->validate([
            'contest_id' => 'required|exists:contests,id',
            'winner_id' => 'required|exists:users,id',
        ]);

        $contest = Contest::findOrFail($validated['contest_id']);
        $winner = User::findOrFail($validated['winner_id']);

        // Verify winner is a participant
        if (!$contest->participants->contains($winner)) {
            return back()->with('error', 'Selected user is not a participant in this contest.');
        }

        // Update contest
        $contest->update([
            'winner_id' => $winner->id,
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Award badge to winner
        $winner->badges()->create([
            'type' => 'contest_winner',
            'name' => 'Contest Winner',
            'description' => "Winner of {$contest->name}",
            'awarded_at' => now(),
        ]);

        // Notify winner and participants
        $winner->notify(new ContestWon($contest));
        foreach ($contest->participants as $participant) {
            if ($participant->id !== $winner->id) {
                $participant->notify(new ContestCompleted($contest));
            }
        }

        return redirect()->route('admin.contests.show', $contest)
            ->with('success', 'Winner selected successfully.');
    }

    /**
     * Remove the specified contest.
     */
    public function destroy(Contest $contest)
    {
        if ($contest->status === 'completed') {
            return back()->with('error', 'Cannot delete a completed contest.');
        }

        $contest->delete();

        return redirect()->route('admin.contests.index')
            ->with('success', 'Contest deleted successfully.');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $transactions = auth()->user()->transactions()
            ->with(['ad', 'user'])
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction): View
    {
        $this->authorize('view', $transaction);
        
        $transaction->load(['ad', 'user']);
        
        return view('transactions.show', compact('transaction'));
    }

    public function store(Request $request, Ad $ad): RedirectResponse
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $transaction = Transaction::create([
            'ad_id' => $ad->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction request sent successfully.');
    }

    public function complete(Transaction $transaction): RedirectResponse
    {
        $this->authorize('complete', $transaction);
        
        $transaction->complete();
        $transaction->user->updateCredibilityScore();

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction completed successfully.');
    }

    public function cancel(Transaction $transaction): RedirectResponse
    {
        $this->authorize('cancel', $transaction);
        
        $transaction->cancel();
        $transaction->user->updateCredibilityScore();

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaction cancelled successfully.');
    }
} 
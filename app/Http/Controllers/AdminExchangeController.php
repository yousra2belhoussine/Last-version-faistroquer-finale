<?php

namespace App\Http\Controllers;

use App\Models\Proposition;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminExchangeController extends Controller
{
    /**
     * Display a listing of exchanges.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');
        
        if ($type === 'propositions') {
            $query = Proposition::query()
                ->with(['user', 'ad.user', 'messages'])
                ->withCount('messages');
        } elseif ($type === 'transactions') {
            $query = Transaction::query()
                ->with(['proposition.user', 'proposition.ad.user']);
        } else {
            // Combined query for both propositions and transactions
            $propositions = Proposition::query()
                ->with(['user', 'ad.user', 'messages'])
                ->withCount('messages')
                ->whereDoesntHave('transaction');

            $transactions = Transaction::query()
                ->with(['proposition.user', 'proposition.ad.user']);

            // Apply filters to both queries
            if ($request->has('category')) {
                $propositions->whereHas('ad', function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
                $transactions->whereHas('proposition.ad', function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            }

            if ($request->has('region')) {
                $propositions->whereHas('ad', function ($q) use ($request) {
                    $q->where('region_id', $request->region);
                });
                $transactions->whereHas('proposition.ad', function ($q) use ($request) {
                    $q->where('region_id', $request->region);
                });
            }

            if ($request->has('user')) {
                $propositions->where(function ($q) use ($request) {
                    $q->where('user_id', $request->user)
                      ->orWhereHas('ad', function ($q) use ($request) {
                          $q->where('user_id', $request->user);
                      });
                });
                $transactions->whereHas('proposition', function ($q) use ($request) {
                    $q->where('user_id', $request->user)
                      ->orWhereHas('ad', function ($q) use ($request) {
                          $q->where('user_id', $request->user);
                      });
                });
            }

            // Combine and paginate results
            $results = $propositions->get()->concat($transactions->get())
                ->sortByDesc('created_at')
                ->values();

            return Inertia::render('Admin/Exchanges/Index', [
                'exchanges' => $results->paginate(20),
                'filters' => $request->only(['type', 'category', 'region', 'user']),
            ]);
        }

        // Apply filters for single type queries
        if ($request->has('category')) {
            $query->whereHas('ad', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        if ($request->has('region')) {
            $query->whereHas('ad', function ($q) use ($request) {
                $q->where('region_id', $request->region);
            });
        }

        if ($request->has('user')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_id', $request->user)
                  ->orWhereHas('ad', function ($q) use ($request) {
                      $q->where('user_id', $request->user);
                  });
            });
        }

        $exchanges = $query->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Exchanges/Index', [
            'exchanges' => $exchanges,
            'filters' => $request->only(['type', 'category', 'region', 'user']),
        ]);
    }

    /**
     * Display the specified exchange.
     */
    public function show(Request $request, $id)
    {
        $type = $request->get('type', 'proposition');
        
        if ($type === 'transaction') {
            $exchange = Transaction::with([
                'proposition.user',
                'proposition.ad.user',
                'proposition.messages',
            ])->findOrFail($id);
        } else {
            $exchange = Proposition::with([
                'user',
                'ad.user',
                'messages',
                'transaction',
            ])->findOrFail($id);
        }

        return Inertia::render('Admin/Exchanges/Show', [
            'exchange' => $exchange,
            'type' => $type,
        ]);
    }

    /**
     * Freeze a proposition.
     */
    public function freeze(Proposition $proposition)
    {
        $proposition->update([
            'status' => 'frozen',
            'frozen_at' => now(),
            'frozen_by' => auth()->id(),
        ]);

        // Notify users about the frozen proposition
        $proposition->user->notify(new PropositionFrozen($proposition));
        $proposition->ad->user->notify(new PropositionFrozen($proposition));

        return back()->with('success', 'Proposition has been frozen.');
    }
} 
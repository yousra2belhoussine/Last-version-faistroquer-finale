<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function index(Request $request)
    {
        $query = Exchange::with(['ad', 'proposer', 'receiver']);

        // Filtrage par type (proposition/transaction)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtrage par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtrage par catégorie d'annonce
        if ($request->has('category')) {
            $query->whereHas('ad', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // Filtrage par utilisateur
        if ($request->has('user')) {
            $userId = $request->user;
            $query->where(function($q) use ($userId) {
                $q->where('proposer_id', $userId)
                  ->orWhere('receiver_id', $userId);
            });
        }

        $exchanges = $query->paginate(20);
        return view('admin.exchanges.index', compact('exchanges'));
    }

    public function show(Exchange $exchange)
    {
        $exchange->load(['ad', 'proposer', 'receiver', 'messages']);
        return view('admin.exchanges.show', compact('exchange'));
    }

    public function freeze(Exchange $exchange, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $exchange->update([
            'status' => 'frozen',
            'freeze_reason' => $request->reason
        ]);

        // Notifier les utilisateurs concernés
        $exchange->proposer->notify(new ExchangeFrozenNotification($exchange));
        $exchange->receiver->notify(new ExchangeFrozenNotification($exchange));

        return redirect()->back()->with('success', 'Échange gelé avec succès');
    }

    public function unfreeze(Exchange $exchange)
    {
        $exchange->update([
            'status' => 'active',
            'freeze_reason' => null
        ]);

        // Notifier les utilisateurs concernés
        $exchange->proposer->notify(new ExchangeUnfrozenNotification($exchange));
        $exchange->receiver->notify(new ExchangeUnfrozenNotification($exchange));

        return redirect()->back()->with('success', 'Échange dégelé avec succès');
    }

    public function close(Exchange $exchange, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $exchange->update([
            'status' => 'closed',
            'closure_reason' => $request->reason
        ]);

        // Notifier les utilisateurs concernés
        $exchange->proposer->notify(new ExchangeClosedNotification($exchange));
        $exchange->receiver->notify(new ExchangeClosedNotification($exchange));

        return redirect()->back()->with('success', 'Échange clôturé avec succès');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminMessageController extends Controller
{
    /**
     * Display a listing of messages.
     */
    public function index(Request $request)
    {
        $query = Message::query()
            ->with(['sender', 'receiver', 'proposition.ad'])
            ->latest();

        // Apply filters
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhereHas('sender', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('receiver', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $messages = $query->paginate(20);

        return Inertia::render('Admin/Messages/Index', [
            'messages' => $messages,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Display messages for a specific proposition.
     */
    public function showPropositionMessages($id)
    {
        $messages = Message::where('proposition_id', $id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $proposition = Proposition::with(['ad', 'user'])->findOrFail($id);

        return Inertia::render('Admin/Messages/Show', [
            'messages' => $messages,
            'proposition' => $proposition
        ]);
    }

    /**
     * Display a specific message.
     */
    public function show($id)
    {
        $message = Message::with(['sender', 'proposition.ad', 'proposition.user'])
            ->findOrFail($id);

        return Inertia::render('Admin/Messages/Detail', [
            'message' => $message
        ]);
    }

    /**
     * Delete a message.
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message supprimé avec succès.');
    }
} 
<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MessageController extends BaseController
{
    public function index()
    {
        $messages = Message::where(function($query) {
            $query->where('sender_id', auth()->id())
                  ->orWhere('receiver_id', auth()->id());
        })
        ->with(['sender', 'receiver'])
        ->latest()
        ->paginate(20);

        return view('messages.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
            'proposition_id' => 'nullable|exists:propositions,id'
        ]);

        $message = Message::create([
            'content' => $validated['content'],
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'proposition_id' => $validated['proposition_id'] ?? null
        ]);

        return redirect()->back()->with('success', 'Message envoyé avec succès');
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        $message->delete();
        return redirect()->back()->with('success', 'Message supprimé avec succès');
    }

    public function show(User $user)
    {
        $messages = Message::where(function($query) use ($user) {
            $query->where(function($q) use ($user) {
                $q->where('sender_id', auth()->id())
                  ->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->where('receiver_id', auth()->id());
            });
        })
        ->with(['sender', 'receiver'])
        ->latest()
        ->paginate(20);

        return view('messages.show', compact('messages', 'user'));
    }
}

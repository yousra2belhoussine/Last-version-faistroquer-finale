<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::latest()->paginate(10);
        $recentUsers = User::whereHas('sentMessages')
            ->orWhereHas('receivedMessages')
            ->latest()
            ->take(10)
            ->get();
            
        $conversations = Conversation::whereHas('participants', function($query) {
            $query->where('users.id', auth()->id());
        })
        ->with(['lastMessage', 'participants' => function($query) {
            $query->where('users.id', '!=', auth()->id());
        }])
        ->latest()
        ->get()
        ->map(function($conversation) {
            $conversation->other_user = $conversation->participants->first();
            return $conversation;
        });
            
        return view('messages.index', compact('messages', 'recentUsers', 'conversations'));
    }

    /**
     * Store a new message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Get or create conversation
            $conversation = $this->getOrCreateConversation($validated['receiver_id']);

            // Create message
            $message = Message::create([
                'content' => $validated['content'],
                'sender_id' => auth()->id(),
                'receiver_id' => $validated['receiver_id'],
                'conversation_id' => $conversation->id,
            ]);

            DB::commit();

            return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to send message. Please try again.');
        }
    }

    /**
     * Get existing conversation or create new one
     *
     * @param int $receiver_id
     * @return \App\Models\Conversation
     */
    private function getOrCreateConversation($receiver_id)
    {
        // Try to find existing private conversation
        $conversation = Conversation::whereHas('participants', function($query) use ($receiver_id) {
            $query->where('users.id', auth()->id());
        })->whereHas('participants', function($query) use ($receiver_id) {
            $query->where('users.id', $receiver_id);
        })->where('type', 'private')
        ->first();

        // If no conversation exists, create new one
        if (!$conversation) {
            $conversation = Conversation::create([
                'type' => 'private'
            ]);

            // Attach participants
            $conversation->participants()->attach([
                auth()->id(),
                $receiver_id
            ]);
        }

        return $conversation;
    }

    /**
     * Display the specified conversation.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        // Verify if the authenticated user is a participant using the pivot table directly
        $isParticipant = DB::table('conversation_user')
            ->where('conversation_id', $conversation->id)
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isParticipant) {
            abort(403, 'You are not authorized to view this conversation.');
        }

        $messages = $conversation->messages()
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        $other_user = $conversation->participants()
            ->where('users.id', '!=', auth()->id())
            ->first();

        if (!$other_user) {
            abort(404, 'Conversation participant not found.');
        }

        return view('messages.show', compact('messages', 'other_user', 'conversation'));
    }

    /**
     * Display direct messages between two users.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function showDirect(User $user)
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
        ->get();

        $other_user = [
            'id' => $user->id,
            'name' => $user->name
        ];

        return view('messages.show', compact('messages', 'other_user'));
    }

    /**
     * Remove the specified message.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);
        $message->delete();
        return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
    }

    /**
     * Store a direct message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDirect(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'recipient_id' => 'required|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Get or create conversation
            $conversation = $this->getOrCreateConversation($validated['recipient_id']);

            // Create message
            $message = Message::create([
                'content' => $validated['content'],
                'sender_id' => auth()->id(),
                'receiver_id' => $validated['recipient_id'],
                'conversation_id' => $conversation->id,
            ]);

            DB::commit();

            return back()->with('success', 'Message sent successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to send message. Please try again.');
        }
    }
} 
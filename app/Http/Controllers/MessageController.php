<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = auth()->user();
        \Log::info('User ID: ' . $user->id);

        // Récupérer les conversations avec leurs derniers messages
        $conversations = $user->conversations()
            ->with(['participants', 'messages' => function($query) {
                $query->latest();
            }, 'messages.sender'])
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('sender_id', '!=', auth()->id())
                    ->where('created_at', '>', function($subquery) {
                        $subquery->select('last_read_at')
                            ->from('conversation_participants')
                            ->whereColumn('conversation_id', 'messages.conversation_id')
                            ->where('user_id', auth()->id())
                            ->limit(1);
                    });
            }])
            ->orderByDesc(function ($query) {
                $query->select('created_at')
                    ->from('messages')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();

        // Déboguer les conversations
        \Log::info('Nombre de conversations: ' . $conversations->count());
        foreach ($conversations as $conversation) {
            \Log::info('Conversation ID: ' . $conversation->id);
            \Log::info('Nombre de messages: ' . $conversation->messages->count());
            \Log::info('Participants: ' . $conversation->participants->pluck('id'));
        }

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Débogage détaillé
        \Log::info('=== Début de la méthode show ===');
        \Log::info('Conversation ID: ' . $conversation->id);
        \Log::info('User ID: ' . auth()->id());
        
        // Charger explicitement la conversation avec ses participants
        $conversation->load('participants');
        
        // Vérifier si la conversation existe et a des participants
        if (!$conversation || !$conversation->participants) {
            \Log::error('Conversation invalide ou sans participants');
            abort(404, 'Conversation non trouvée');
        }
        
        \Log::info('Participants: ' . $conversation->participants->pluck('id'));

        // Vérifier si l'utilisateur est participant
        if (!$conversation->participants->contains(auth()->id())) {
            \Log::error('Utilisateur non autorisé à accéder à cette conversation');
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette conversation');
        }

        try {
            // Récupérer toutes les conversations pour la sidebar avec les participants et leurs photos
            $conversations = auth()->user()->conversations()
                ->with(['participants' => function($query) {
                    $query->select('users.id', 'users.name', 'users.profile_photo_path');
                }, 'lastMessage'])
                ->withCount(['messages as unread_count' => function ($query) {
                    $query->where('sender_id', '!=', auth()->id())
                        ->whereDoesntHave('reads', function($q) {
                            $q->where('user_id', auth()->id());
                        });
                }])
                ->orderByDesc(function ($query) {
                    $query->select('created_at')
                        ->from('messages')
                        ->whereColumn('conversation_id', 'conversations.id')
                        ->latest()
                        ->limit(1);
                })
                ->get();

            \Log::info('Nombre de conversations dans la sidebar: ' . $conversations->count());

            // Récupérer les messages de la conversation actuelle avec les expéditeurs et leurs photos
            $messages = $conversation->messages()
                ->with(['sender' => function($query) {
                    $query->select('users.id', 'users.name', 'users.profile_photo_path');
                }])
                ->orderBy('created_at', 'asc')
                ->get();

            \Log::info('Nombre de messages dans la conversation: ' . $messages->count());
            
            // Marquer la conversation comme lue
            $conversation->markAsRead(auth()->id());
            
            \Log::info('=== Fin de la méthode show ===');

            return view('messages.show', compact('conversation', 'messages', 'conversations'));
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement de la conversation: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            abort(500, 'Une erreur est survenue lors du chargement de la conversation');
        }
    }

    public function store(Request $request, Conversation $conversation)
    {
        // Vérifier si l'utilisateur est participant
        abort_if(!$conversation->participants->contains(auth()->id()), 403);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Message envoyé');
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('messages.create', compact('users'));
    }

    public function startConversation(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        // Trouver ou créer une conversation privée entre les deux utilisateurs
        $conversation = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('participants', function ($query) use ($validated) {
            $query->where('user_id', $validated['recipient_id']);
        })->where('type', 'private')->first();

        if (!$conversation) {
            $conversation = Conversation::create(['type' => 'private']);
            $conversation->participants()->attach([
                auth()->id(),
                $validated['recipient_id']
            ]);
        }

        // Créer le message
        $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Message envoyé');
    }

    public function showDirectConversation(User $user)
    {
        // Vérifier qu'on ne tente pas de démarrer une conversation avec soi-même
        if ($user->id === auth()->id()) {
            return redirect()->route('messages.index')
                ->with('error', 'Vous ne pouvez pas démarrer une conversation avec vous-même.');
        }

        // Trouver ou créer une conversation privée entre les deux utilisateurs
        $conversation = Conversation::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id());
        })->whereHas('participants', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('type', 'private')->first();

        if (!$conversation) {
            $conversation = Conversation::create(['type' => 'private']);
            $conversation->participants()->attach([
                auth()->id(),
                $user->id
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    public function contactSeller(Request $request, User $seller)
    {
        // Vérifier que l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour envoyer un message.');
        }

        // Valider les données du formulaire
        $validated = $request->validate([
            'message' => 'required|string|min:2|max:1000',
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 2 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 1000 caractères.'
        ]);

        // Vérifier qu'on ne tente pas de s'envoyer un message à soi-même
        if ($seller->id === auth()->id()) {
            return back()
                ->withInput()
                ->with('error', 'Vous ne pouvez pas vous envoyer un message à vous-même.');
        }

        try {
            // Trouver ou créer une conversation privée
            $conversation = Conversation::whereHas('participants', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereHas('participants', function ($query) use ($seller) {
                $query->where('user_id', $seller->id);
            })->where('type', 'private')->first();

            if (!$conversation) {
                $conversation = Conversation::create(['type' => 'private']);
                $conversation->participants()->attach([
                    auth()->id(),
                    $seller->id
                ]);
            }

            // Créer le message
            $conversation->messages()->create([
                'sender_id' => auth()->id(),
                'content' => $validated['message']
            ]);

            return redirect()->route('messages.show', $conversation)
                ->with('success', 'Message envoyé avec succès !');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.');
        }
    }

    public function activeUsers()
    {
        // Récupérer tous les utilisateurs qui ont envoyé des messages
        $activeUsers = \App\Models\User::whereHas('messages')
            ->withCount(['messages' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->with(['messages' => function($query) {
                $query->latest()->limit(1);
            }])
            ->orderBy('messages_count', 'desc')
            ->get();

        return view('messages.active_users', compact('activeUsers'));
    }
} 
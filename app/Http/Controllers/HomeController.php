<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Article;
use App\Models\Category;
use App\Models\Message;
use App\Models\Proposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $categories = Category::withCount('ads')->get();
        $featuredAds = Ad::featured()->with(['category', 'user'])->take(8)->get();
        $latestAds = Ad::with(['category', 'user', 'images'])
            ->latest()
            ->take(8)
            ->get();
        
        // Récupération des 3 derniers articles
        $articles = Article::with(['user'])
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)  // Limité à 3 articles
            ->get()
            ->map(function ($article) {
                $article->formatted_date = $article->published_at->format('d M Y');
                return $article;
            });

        return view('home', compact('categories', 'featuredAds', 'latestAds', 'articles'));
    }

    /**
     * Display the dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get proposition statistics
        $propositionStats = [
            'total' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->count(),
            'pending' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->where('status', 'pending')->count(),
            'accepted' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->where('status', 'accepted')->count(),
            'completed' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->where('status', 'completed')->count(),
            'rejected' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->where('status', 'rejected')->count(),
            'cancelled' => Proposition::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('ad', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })->where('status', 'cancelled')->count(),
        ];
        
        // Get recent messages for the dashboard
        $recentMessages = $this->getRecentMessages($user);

        // Get unread messages count
        $unreadCount = $this->getUnreadMessagesCount($user);

        return view('dashboard', [
            'recentMessages' => $recentMessages,
            'unreadCount' => $unreadCount,
            'propositionStats' => $propositionStats,
        ]);
    }

    /**
     * Get recent messages for the dashboard
     */
    private function getRecentMessages($user)
    {
        return Message::whereHas('conversation.participants', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->with(['sender', 'conversation.participants'])
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get()
        ->map(function ($message) use ($user) {
            $otherParticipant = $message->conversation->participants
                ->where('id', '!=', $user->id)
                ->first();

            return [
                'id' => $message->id,
                'content' => $message->content,
                'created_at' => $message->created_at,
                'is_read' => $message->is_read,
                'other_user' => $otherParticipant ? [
                    'id' => $otherParticipant->id,
                    'name' => $otherParticipant->name,
                    'profile_photo_url' => $otherParticipant->profile_photo_url
                ] : null,
                'type' => $message->type,
                'conversation_id' => $message->conversation_id
            ];
        });
    }

    /**
     * Get unread messages count
     */
    private function getUnreadMessagesCount($user)
    {
        return Message::whereHas('conversation.participants', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->where('sender_id', '!=', $user->id)
        ->whereDoesntHave('reads', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->count();
    }

    public function howItWorks()
    {
        return view('pages.how-it-works', [
            'metaTitle' => 'Comment ça marche - FAISTROQUER',
            'metaDescription' => 'Découvrez comment fonctionne FAISTROQUER, la plateforme d\'échange de biens et services. Apprenez à échanger en toute confiance.',
        ]);
    }

    public function faq()
    {
        return view('pages.faq', [
            'metaTitle' => 'FAQ - Questions fréquentes - FAISTROQUER',
            'metaDescription' => 'Trouvez les réponses à vos questions sur FAISTROQUER. Consultez notre FAQ pour tout savoir sur le fonctionnement de la plateforme.',
        ]);
    }

    public function help()
    {
        return view('pages.help', [
            'metaTitle' => 'Aide et Support - FAISTROQUER',
            'metaDescription' => 'Besoin d\'aide ? Consultez notre centre d\'aide pour trouver des réponses à vos questions et obtenir de l\'assistance.',
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'metaTitle' => 'À propos - FAISTROQUER',
            'metaDescription' => 'Découvrez qui nous sommes et notre mission chez FAISTROQUER. En savoir plus sur notre plateforme d\'échange de biens et services.',
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'metaTitle' => 'Contact - FAISTROQUER',
            'metaDescription' => 'Contactez-nous pour toute question ou suggestion concernant FAISTROQUER. Notre équipe est là pour vous aider.',
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'metaTitle' => 'Conditions d\'utilisation - FAISTROQUER',
            'metaDescription' => 'Consultez nos conditions d\'utilisation pour comprendre vos droits et obligations sur FAISTROQUER.',
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy', [
            'metaTitle' => 'Politique de confidentialité - FAISTROQUER',
            'metaDescription' => 'Découvrez comment nous protégeons vos données personnelles sur FAISTROQUER.',
        ]);
    }

    public function legal()
    {
        return view('pages.legal', [
            'metaTitle' => 'Mentions légales - FAISTROQUER',
            'metaDescription' => 'Consultez nos mentions légales pour plus d\'informations sur FAISTROQUER.',
        ]);
    }

    public function cookies()
    {
        return view('pages.cookies', [
            'metaTitle' => 'Gestion des cookies - FAISTROQUER',
            'metaDescription' => 'Découvrez comment nous utilisons les cookies sur FAISTROQUER et gérez vos préférences.',
        ]);
    }

    public function safety()
    {
        return view('pages.safety', [
            'metaTitle' => 'Conseils de sécurité - FAISTROQUER',
            'metaDescription' => 'Consultez nos conseils de sécurité pour échanger en toute confiance sur FAISTROQUER.',
        ]);
    }
} 
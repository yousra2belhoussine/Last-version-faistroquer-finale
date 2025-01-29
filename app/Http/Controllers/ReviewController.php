<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display reviews for a user.
     */
    public function index(User $user)
    {
        $reviews = $user->receivedReviews()
            ->with('reviewer')
            ->latest()
            ->paginate(10);

        return Inertia::render('Reviews/Index', [
            'user' => $user->load('badges'),
            'reviews' => $reviews,
            'stats' => [
                'average_rating' => $user->receivedReviews()->avg('rating'),
                'total_reviews' => $user->receivedReviews()->count(),
                'rating_distribution' => $user->receivedReviews()
                    ->selectRaw('rating, COUNT(*) as count')
                    ->groupBy('rating')
                    ->get()
                    ->pluck('count', 'rating'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new review.
     */
    public function create(Transaction $transaction)
    {
        // Verify user can review this transaction
        if (!$this->canReview($transaction)) {
            return back()->with('error', 'You cannot review this transaction.');
        }

        $otherUser = $transaction->proposition->user_id === auth()->id()
            ? $transaction->proposition->ad->user
            : $transaction->proposition->user;

        return Inertia::render('Reviews/Create', [
            'transaction' => $transaction->load('proposition.ad'),
            'user' => $otherUser,
        ]);
    }

    /**
     * Store a newly created review.
     */
    public function store(Request $request, Transaction $transaction)
    {
        // Verify user can review this transaction
        if (!$this->canReview($transaction)) {
            return back()->with('error', 'You cannot review this transaction.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'tags' => 'nullable|array',
            'tags.*' => 'string|in:friendly,punctual,reliable,professional,good_communication',
        ]);

        // Determine who is being reviewed
        $reviewedUser = $transaction->proposition->user_id === auth()->id()
            ? $transaction->proposition->ad->user
            : $transaction->proposition->user;

        // Create review
        $review = Review::create([
            'reviewer_id' => auth()->id(),
            'reviewed_id' => $reviewedUser->id,
            'transaction_id' => $transaction->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'tags' => $validated['tags'] ?? [],
        ]);

        // Update user's credibility score
        $this->updateUserCredibility($reviewedUser);

        // Award badges if applicable
        $this->checkAndAwardBadges($reviewedUser);

        // Notify the reviewed user
        $reviewedUser->notify(new NewReview($review));

        return redirect()->route('users.reviews.index', $reviewedUser)
            ->with('success', 'Review submitted successfully.');
    }

    /**
     * Report a review.
     */
    public function report(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reason' => 'required|string|in:inappropriate,spam,offensive,false',
            'description' => 'required|string|min:10',
        ]);

        $report = $review->reports()->create([
            'reporter_id' => auth()->id(),
            'reason' => $validated['reason'],
            'description' => $validated['description'],
        ]);

        // Notify admins
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new NewReviewReport($report));

        return back()->with('success', 'Review reported successfully.');
    }

    /**
     * Check if user can review a transaction.
     */
    private function canReview(Transaction $transaction): bool
    {
        // Must be completed transaction
        if ($transaction->status !== 'completed') {
            return false;
        }

        // Must be participant in transaction
        if ($transaction->proposition->user_id !== auth()->id() && 
            $transaction->proposition->ad->user_id !== auth()->id()) {
            return false;
        }

        // Check if already reviewed
        $hasReviewed = Review::where('transaction_id', $transaction->id)
            ->where('reviewer_id', auth()->id())
            ->exists();

        return !$hasReviewed;
    }

    /**
     * Update user's credibility score based on reviews.
     */
    private function updateUserCredibility(User $user): void
    {
        $averageRating = $user->receivedReviews()->avg('rating');
        $reviewCount = $user->receivedReviews()->count();
        $transactionCount = $user->transactions()->count();

        // Calculate credibility score (example algorithm)
        $credibilityScore = min(100, (
            ($averageRating * 10) + 
            ($reviewCount * 2) + 
            ($transactionCount * 3)
        ));

        $user->update(['credibility_score' => $credibilityScore]);
    }

    /**
     * Check and award badges based on reviews.
     */
    private function checkAndAwardBadges(User $user): void
    {
        $reviewCount = $user->receivedReviews()->count();
        $averageRating = $user->receivedReviews()->avg('rating');

        // Award badges based on review count
        if ($reviewCount >= 100 && !$user->badges()->where('type', 'trusted_100')->exists()) {
            $user->badges()->create([
                'type' => 'trusted_100',
                'name' => 'Trusted Member',
                'description' => 'Received 100 reviews',
            ]);
        }

        // Award badges based on average rating
        if ($reviewCount >= 10 && $averageRating >= 4.5 && !$user->badges()->where('type', 'top_rated')->exists()) {
            $user->badges()->create([
                'type' => 'top_rated',
                'name' => 'Top Rated',
                'description' => 'Maintained 4.5+ rating with 10+ reviews',
            ]);
        }
    }
} 
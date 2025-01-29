<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_id',
        'reviewer_id',
        'reviewed_id',
        'rating',
        'comment',
        'reported_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'reported_at' => 'datetime',
    ];

    /**
     * Get the user who wrote the review.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
 
    /**
     * Get the user who received the review.
     */
    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_id');
    }

    /**
     * Get the transaction associated with the review.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Scope a query to only include positive reviews.
     */
    public function scopePositive($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Scope a query to only include negative reviews.
     */
    public function scopeNegative($query)
    {
        return $query->where('is_positive', false);
    }

    /**
     * Update user credibility after review.
     */
    protected static function booted()
    {
        static::created(function ($review) {
            $credibilityChange = $review->is_positive ? 1 : -1;
            $review->reviewed->increment('credibility_score', $credibilityChange);
        });

        static::deleted(function ($review) {
            $credibilityChange = $review->is_positive ? -1 : 1;
            $review->reviewed->increment('credibility_score', $credibilityChange);
        });
    }
}

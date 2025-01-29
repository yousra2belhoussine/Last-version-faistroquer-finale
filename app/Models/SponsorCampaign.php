<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorCampaign extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sponsor_id',
        'name',
        'description',
        'banner_images',
        'target_url',
        'starts_at',
        'ends_at',
        'is_active',
        'views_count',
        'clicks_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'banner_images' => 'json',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'clicks_count' => 'integer',
    ];

    /**
     * Get the sponsor that owns the campaign.
     */
    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    /**
     * Scope a query to only include active campaigns.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at');
            });
    }

    /**
     * Increment the views count.
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment the clicks count.
     */
    public function incrementClicks()
    {
        $this->increment('clicks_count');
    }

    /**
     * Check if the campaign is currently running.
     */
    public function isRunning(): bool
    {
        return $this->is_active &&
            $this->starts_at <= now() &&
            ($this->ends_at === null || $this->ends_at > now());
    }

    /**
     * Get the click-through rate (CTR) for the campaign.
     */
    public function getClickThroughRateAttribute(): float
    {
        if ($this->views_count === 0) {
            return 0;
        }

        return ($this->clicks_count / $this->views_count) * 100;
    }
}

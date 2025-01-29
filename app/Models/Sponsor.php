<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'contact_name',
        'contact_email',
        'contact_phone',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the campaigns for the sponsor.
     */
    public function campaigns()
    {
        return $this->hasMany(SponsorCampaign::class);
    }

    /**
     * Get active campaigns for the sponsor.
     */
    public function activeCampaigns()
    {
        return $this->campaigns()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at');
            });
    }

    /**
     * Scope a query to only include active sponsors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the total views across all campaigns.
     */
    public function getTotalViewsAttribute()
    {
        return $this->campaigns()->sum('views_count');
    }

    /**
     * Get the total clicks across all campaigns.
     */
    public function getTotalClicksAttribute()
    {
        return $this->campaigns()->sum('clicks_count');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'type',
        'status',
        'department',
        'city',
        'postal_code',
        'exchange_with',
        'online_exchange',
        'price',
        'condition',
        'is_online',
        'is_featured',
        'views_count',
        'region_id',
        'expires_at',
        'rejection_reason'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'views_count' => 'integer',
        'is_online' => 'boolean',
        'is_featured' => 'boolean',
        'online_exchange' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(Image::class)->where('is_primary', true);
    }

    public function propositions(): HasMany
    {
        return $this->hasMany(Proposition::class);
    }

    public function scopeFeatured($query)
    {
        return $query->where('status', 'active')
                    ->where('is_featured', true)
                    ->latest();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}

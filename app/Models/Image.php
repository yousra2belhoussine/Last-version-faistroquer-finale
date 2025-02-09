<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_id',
        'image_path',
        'title',
        'description',
        'order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the ad that owns the image.
     */
    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get the full URL of the image.
     */
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->image_path);
    }

    /**
     * Delete the image file when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            Storage::disk('public')->delete($image->image_path);
        });
    }
}

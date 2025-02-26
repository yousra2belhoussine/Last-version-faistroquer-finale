<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'ad_id',
        'order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer'
    ];

    protected $appends = ['url'];

    /**
     * Get the ad that owns the image.
     */
    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }

    /**
     * Get the full URL of the image.
     */
    public function getUrlAttribute()
    {
        if (empty($this->path)) {
            return asset('images/default-ad-image.png');
        }

        // Si le chemin commence déjà par 'storage/', on ne l'ajoute pas deux fois
        if (str_starts_with($this->path, 'storage/')) {
            return asset($this->path);
        }

        // Sinon, on s'assure que le chemin est correctement formaté pour le stockage public
        return asset('storage/' . $this->path);
    }

    /**
     * Delete the image file when the model is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            if ($image->path) {
                Storage::disk('public')->delete($image->path);
            }
        });
    }
}

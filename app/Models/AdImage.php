<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdImage extends Model
{
    protected $fillable = ['image_path', 'ad_id'];

    protected $appends = ['image_url'];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function getImageUrlAttribute()
    {
        // Si le chemin est vide ou null, retourner l'image par défaut
        if (empty($this->image_path)) {
            return asset('images/default-avatar.png');
        }

        // Si le chemin commence par 'images/', c'est une image dans le dossier public
        if (str_starts_with($this->image_path, 'images/')) {
            $path = public_path($this->image_path);
            return file_exists($path) ? asset($this->image_path) : asset('images/default-avatar.png');
        }

        // Pour les images dans le storage
        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        // Si aucune condition n'est remplie, retourner l'image par défaut
        return asset('images/default-avatar.png');
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_path',
        'ad_id'
    ];

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}

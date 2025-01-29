<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exchange extends Model
{
    protected $fillable = [
        'user_id',
        'ad_id',
        'status',
        'type',
        'notes',
        'meeting_date',
        'meeting_location',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ad(): BelongsTo
    {
        return $this->belongsTo(Ad::class);
    }
} 
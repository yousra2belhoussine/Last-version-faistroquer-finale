<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'proposition_id',
        'status',
        'meeting_location',
        'meeting_date',
        'completed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function proposition()
    {
        return $this->belongsTo(Proposition::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

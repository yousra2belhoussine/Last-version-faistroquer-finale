<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'ad_id',
        'status',
        'message',
        'offer',
        'online_exchange',
        'meeting_location',
        'meeting_date',
        'price',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'meeting_date' => 'datetime',
        'online_exchange' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ad()
    {
        return $this->belongsTo(Ad::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
} 
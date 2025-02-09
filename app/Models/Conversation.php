<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type'
    ];

    protected $with = ['participants'];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function unreadMessagesCount($userId)
    {
        $lastRead = $this->participants()->where('user_id', $userId)->first()?->pivot->last_read_at;
        
        return $this->messages()
                    ->where('sender_id', '!=', $userId)
                    ->when($lastRead, function ($query) use ($lastRead) {
                        return $query->where('created_at', '>', $lastRead);
                    })
                    ->count();
    }

    public function markAsRead($userId)
    {
        return $this->participants()
                    ->where('user_id', $userId)
                    ->update(['last_read_at' => now()]);
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content'
    ];

    protected $with = ['sender'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function reads()
    {
        return $this->hasMany(MessageRead::class);
    }

    public function isUnread()
    {
        return !$this->reads()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function markAsRead($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        if (!$this->reads()->where('user_id', $userId)->exists()) {
            return $this->reads()->create([
                'user_id' => $userId,
                'read_at' => now()
            ]);
        }
    }

    public function scopeUnread(Builder $query)
    {
        return $query->whereDoesntHave('reads', function($query) {
            $query->where('user_id', auth()->id());
        });
    }

    public function scopeForUser(Builder $query, $userId)
    {
        return $query->whereHas('conversation.participants', function($query) use ($userId) {
            $query->where('users.id', $userId);
        });
    }
} 
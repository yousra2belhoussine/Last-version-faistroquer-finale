<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
    ];

    /**
     * Get all participants in the conversation.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withTimestamps();
    }

    /**
     * Get the last message of the conversation.
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Get all messages in the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the other participant in a private conversation.
     */
    public function otherUser()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->where('users.id', '!=', auth()->id())
                    ->take(1);
    }

    /**
     * Get the other user attribute.
     */
    public function getOtherUserAttribute()
    {
        return $this->otherUser()->first();
    }

    /**
     * Scope a query to include the other user in the conversation.
     */
    public function scopeWithOtherUser($query)
    {
        return $query->with(['participants' => function($q) {
            $q->where('users.id', '!=', auth()->id());
        }]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'is_validated',
        'company_name',
        'siret',
        'phone',
        'bio',
        'notification_preferences',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'notification_preferences' => 'array',
        'is_admin' => 'boolean',
        'banned_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_validated' => 'boolean',
    ];

    public function isBanned()
    {
        return !is_null($this->banned_at);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isProfessional()
    {
        return $this->type === 'professional';
    }

    public function isValidated()
    {
        return $this->is_validated;
    }

    // Relations
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function propositions()
    {
        return $this->hasMany(Proposition::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'reviewed_id');
    }

    /**
     * Get the badges earned by the user.
     */
    public function badges()
    {
        return $this->hasMany(Badge::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function disputes()
    {
        return $this->hasMany(Dispute::class, 'reporter_id');
    }

    /**
     * Get the completed exchanges for the user.
     */
    public function completedExchanges()
    {
        return $this->hasMany(Exchange::class)->where('status', 'completed');
    }

    /**
     * Get all conversations the user is part of.
     */
    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
                    ->withPivot('role', 'last_read_at', 'is_muted')
                    ->withTimestamps();
    }

    /**
     * Get all messages sent by the user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get all messages received by the user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    /**
     * Get all unread messages in user's conversations.
     */
    public function unreadMessages()
    {
        return Message::whereHas('conversation.participants', function($query) {
            $query->where('users.id', $this->id);
        })
        ->where('sender_id', '!=', $this->id)
        ->whereDoesntHave('reads', function($query) {
            $query->where('user_id', $this->id);
        });
    }

    /**
     * Get all messages sent or received by the user.
     */
    public function messages()
    {
        return Message::whereHas('conversation.participants', function($query) {
            $query->where('users.id', $this->id);
        });
    }

    /**
     * Get all message reads by the user.
     */
    public function messageReads()
    {
        return $this->hasMany(MessageRead::class);
    }

    /**
     * Get all message reactions by the user.
     */
    public function messageReactions()
    {
        return $this->hasMany(MessageReaction::class);
    }

    /**
     * Get the URL of the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return url('storage/' . $this->profile_photo_path);
        }
        return null;
    }
}

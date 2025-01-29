<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Review;

class User extends Authenticatable implements MustVerifyEmail
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
     * Get the unread messages for the user.
     */
    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id')
            ->whereNull('read_at');
    }

    /**
     * Get all received messages for the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get sent messages by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get all conversations the user is part of.
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user')
                    ->withTimestamps();
    }

    /**
     * Get all messages (sent and received).
     */
    public function messages()
    {
        return Message::where(function($query) {
            $query->where('sender_id', $this->id)
                  ->orWhere('receiver_id', $this->id);
        });
    }
}

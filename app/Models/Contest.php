<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'criteria',
        'starts_at',
        'ends_at',
        'winner_id',
        'prizes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'criteria' => 'json',
        'prizes' => 'json',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the winner of the contest.
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Get the participants of the contest.
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'contest_participants')
            ->withPivot('score', 'participation_data')
            ->withTimestamps();
    }

    /**
     * Get the top participants of the contest.
     */
    public function topParticipants($limit = 10)
    {
        return $this->participants()
            ->orderByPivot('score', 'desc')
            ->limit($limit);
    }

    /**
     * Scope a query to only include active contests.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->where('ends_at', '>', now())
                    ->orWhereNull('ends_at');
            });
    }

    /**
     * Scope a query to only include contests of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if the contest is currently running.
     */
    public function isRunning(): bool
    {
        return $this->is_active &&
            $this->starts_at <= now() &&
            ($this->ends_at === null || $this->ends_at > now());
    }

    /**
     * Check if the contest has ended.
     */
    public function hasEnded(): bool
    {
        return $this->ends_at !== null && $this->ends_at <= now();
    }

    /**
     * Add a participant to the contest.
     */
    public function addParticipant(User $user, array $data = [])
    {
        if (!$this->participants()->where('user_id', $user->id)->exists()) {
            $this->participants()->attach($user->id, [
                'score' => 0,
                'participation_data' => json_encode($data),
            ]);
        }
    }

    /**
     * Update participant's score.
     */
    public function updateParticipantScore(User $user, int $score)
    {
        $this->participants()->updateExistingPivot($user->id, [
            'score' => $score,
        ]);
    }

    /**
     * Set the winner of the contest.
     */
    public function setWinner(User $user)
    {
        $this->update([
            'winner_id' => $user->id,
        ]);

        // Award the contest winner badge
        $badge = Badge::where('type', 'contest_winner')->first();
        if ($badge) {
            $user->badges()->attach($badge->id, [
                'awarded_at' => now(),
                'award_data' => json_encode(['contest_id' => $this->id]),
            ]);
        }
    }
}

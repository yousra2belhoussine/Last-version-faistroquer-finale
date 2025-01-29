<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reporter_id',
        'reported_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'description',
        'status',
        'admin_notes',
        'admin_id',
        'resolved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the user who made the report.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the user who was reported.
     */
    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    /**
     * Get the admin who handled the report.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the reportable entity.
     */
    public function reportable()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include open reports.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include resolved reports.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Scope a query to only include reports under review.
     */
    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    /**
     * Scope a query to only include dismissed reports.
     */
    public function scopeDismissed($query)
    {
        return $query->where('status', 'dismissed');
    }

    /**
     * Mark the report as resolved.
     */
    public function resolve(User $admin, string $notes = null)
    {
        $this->update([
            'status' => 'resolved',
            'admin_id' => $admin->id,
            'admin_notes' => $notes,
            'resolved_at' => now(),
        ]);
    }

    /**
     * Mark the report as under review.
     */
    public function markAsUnderReview(User $admin)
    {
        $this->update([
            'status' => 'under_review',
            'admin_id' => $admin->id,
        ]);
    }

    /**
     * Dismiss the report.
     */
    public function dismiss(User $admin, string $notes = null)
    {
        $this->update([
            'status' => 'dismissed',
            'admin_id' => $admin->id,
            'admin_notes' => $notes,
            'resolved_at' => now(),
        ]);
    }
}

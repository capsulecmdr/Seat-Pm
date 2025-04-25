<?php

namespace CapsuleCmdr\SeATPM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $table = 'seatpm_tasks';

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'target_start_date',
        'target_completion_date',
        'budget_cost',
        'status',
        'percent_complete',
    ];

    /**
     * The parent project of this task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The user who created this task.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(\Seat\Web\Models\User::class, 'user_id');
    }

    /**
     * The comments associated with this task.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Return true if this task is considered overdue.
     */
    public function isOverdue(): bool
    {
        return $this->target_completion_date && now()->gt($this->target_completion_date) && $this->status !== 'Complete';
    }

    /**
     * Return a readable status badge class.
     */
    public function statusClass(): string
    {
        return match ($this->status) {
            'Complete' => 'success',
            'In Progress' => 'primary',
            'Blocked' => 'danger',
            'Backlog' => 'secondary',
            default => 'light',
        };
    }
}

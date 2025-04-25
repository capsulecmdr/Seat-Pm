<?php

namespace CapsuleCmdr\SeATPM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $table = 'seatpm_projects';

    protected $fillable = [
        'user_id',
        'title',
        'visibility',
        'description',
        'target_budget',
        'target_completion_date',
    ];

    /**
     * Get the user who owns the project.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(\Seat\Web\Models\User::class, 'user_id');
    }

    /**
     * Get the tasks under this project.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Calculate overall percent complete based on tasks.
     */
    public function percentComplete(): int
    {
        if ($this->tasks->count() === 0) {
            return 0;
        }

        $total = $this->tasks->sum('percent_complete');
        return (int) round($total / $this->tasks->count());
    }

    /**
     * Scope projects by a given visibility.
     */
    public function scopeVisibleBy($query, $user, $scope)
    {
        return match ($scope) {
            'alliance' => $query->where('visibility', 'alliance')
                                ->whereHas('owner', fn($q) => $q->where('alliance_id', $user->alliance_id)),

            'corporation' => $query->where('visibility', 'corporation')
                                   ->whereHas('owner', fn($q) => $q->where('corporation_id', $user->corporation_id)),

            default => $query->where('visibility', 'personal')
                             ->where('user_id', $user->id),
        };
    }
}

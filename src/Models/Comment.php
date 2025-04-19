<?php

namespace CapsuleCmdr\SeATPM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'seatpm_comments';

    protected $fillable = [
        'task_id',
        'user_id',
        'message',
    ];

    /**
     * Get the task this comment belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the user who wrote this comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\Seat\Eveapi\Models\Character\CharacterInfo::class, 'user_id', 'user_id');
    }
}

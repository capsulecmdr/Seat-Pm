<?php

namespace CapsuleCmdr\SeATPM\Policies;

use CapsuleCmdr\SeATPM\Models\Comment;
use Seat\Web\Models\User;

class CommentPolicy
{
    /**
     * Determine if the user can update the comment.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->can('seatpm.super');
    }

    /**
     * Determine if the user can delete the comment.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->can('seatpm.super');
    }
}

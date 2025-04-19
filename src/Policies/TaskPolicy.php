<?php

namespace CapsuleCmdr\SeATPM\Policies;

use CapsuleCmdr\SeATPM\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Allow full access for superusers.
     */
    public function before(User $user, $ability): bool|null
    {
        return $user->hasPermissionTo('seatpm.super') ? true : null;
    }

    /**
     * View a task (if the user can view its project).
     */
    public function view(User $user, Task $task): bool
    {
        return $user->can('view', $task->project);
    }

    /**
     * Update a task (if the user can update the project).
     */
    public function update(User $user, Task $task): bool
    {
        return $user->can('update', $task->project);
    }

    /**
     * Delete a task (if the user owns the project).
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->can('delete', $task->project);
    }

    /**
     * Create a new task under a project.
     */
    public function create(User $user, \CapsuleCmdr\SeATPM\Models\Project $project): bool
    {
        return $user->can('update', $project);
    }
}

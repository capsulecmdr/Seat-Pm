<?php

namespace CapsuleCmdr\SeATPM\Policies;

use CapsuleCmdr\SeATPM\Models\Project;
use Seat\Web\Models\User;

class ProjectPolicy
{
    /**
     * Allow superusers to do anything.
     */
    public function before(User $user, $ability): bool|null
    {
        return $user->hasPermissionTo('seatpm.super') ? true : null;
    }

    /**
     * View a project.
     */
    public function view(User $user, Project $project): bool
    {
        return match ($project->visibility) {
            'alliance' => $user->alliance_id && $user->alliance_id === optional($project->owner)->alliance_id,
            'corporation' => $user->corporation_id && $user->corporation_id === optional($project->owner)->corporation_id,
            'personal' => $user->id === $project->user_id,
            default => false,
        };
    }

    /**
     * Create a new project.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('seatpm.projects.create');
    }

    /**
     * Update a project.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    /**
     * Delete a project.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}

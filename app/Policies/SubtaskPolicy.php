<?php

namespace App\Policies;

use App\Models\Subtask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubtaskPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['handle tasks', 'view subtasks']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subtask $subtask): bool
    {
        // TODO (toheeb): People that should view a subtask are those that have something to do with the subtask
        return $user->hasAnyPermission(['handle subtasks', 'view subtasks']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['handle subtasks', 'create subtasks']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subtask $subtask): bool
    {
        return $user->hasAnyPermission(['handle subtasks']) || ($user->hasPermissionTo('update subtasks') && ($user->id === $subtask->task->project->user_id || $user->id === $subtask->assigned_user_id || $subtask->task->assigned_user_id));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subtask $subtask): bool
    {
        // TODO(toheeb): eager load relationships here to make things fast
        return $user->hasAnyPermission(['handle subtasks']) || ($user->hasPermissionTo('delete subtasks') && ($user->id === $subtask->task->project->user_id || $subtask->task->assigned_user_id));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subtask $subtask): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subtask $subtask): bool
    {
        return false;
    }
}

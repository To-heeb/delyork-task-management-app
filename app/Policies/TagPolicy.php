<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
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
        return $user->hasAnyPermission(['handle tags', 'view tags']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tag $tag): bool
    {
        return $user->hasAnyPermission(['handle tags', 'view tags']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['handle tags', 'create tags']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag): bool
    {
        return $user->hasAnyPermission(['handle projects', 'update tags']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag): bool
    {
        return $user->hasAnyPermission(['handle projects', 'delete tags']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return false;
    }
}
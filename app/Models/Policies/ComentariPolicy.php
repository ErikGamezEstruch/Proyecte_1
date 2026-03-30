<?php

namespace App\Models\Policies;

use App\Models\Comentari;
use App\Models\User;

class ComentariPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comentari $comentari): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $ticket): bool
    {
        // Solo puede comentar si puede ver el ticket
        return $user->can('view', $ticket);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comentari $comentari): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comentari $comentari): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comentari $comentari): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comentari $comentari): bool
    {
        return false;
    }
}

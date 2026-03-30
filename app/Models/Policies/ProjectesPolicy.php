<?php

namespace App\Models\Policies;

use App\Models\Projectes;
use App\Models\User;

class ProjectesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Quién puede ver la lista de proyectos
        // Todos autenticados pueden intentarlo, pero el index del controller filtrará
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Projectes $projecte): bool
    {
        if ($user->hasRole(['ADMIN','GESTOR'])) return true; // ven todos
        if ($user->hasRole('DESENVOLUPADOR')) {
            // Solo si es miembro del proyecto (pivot devs)
            return $projecte->devs->contains($user->id);
        }
        if ($user->hasRole('CLIENT')) {
            // Solo su cliente
            return $projecte->client_id === $user->client_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user ->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Projectes $projecte): bool
    {
        // ADMIN/GESTOR pueden actualizar cualquier proyecto
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Projectes $projecte): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Projectes $projecte): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Projectes $projecte): bool
    {
        return false;
    }
}

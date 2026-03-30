<?php

namespace App\Models\Policies;

use App\Models\Projectes;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
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
    public function view(User $user, Ticket $ticket): bool
    {
        $projecte = $ticket->projecte;
        if ($user->hasRole(['ADMIN','GESTOR'])) return true; // ven todo
        if ($user->hasRole('DESENVOLUPADOR')) return $projecte->devs->contains($user->id); // solo sus proyectos
        if ($user->hasRole('CLIENT')) return $projecte->client_id === $user->client_id; // tickets de su cliente
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Projectes $projecte): bool
    {
        return $user->hasRole('GESTOR') ||
            ($user->hasRole('DESENVOLUPADOR') && $projecte->devs->contains($user->id));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        // Igual que create: GESTOR o DEV en sus proyectos
        $projecte = $ticket->projecte;
        return $projecte && ($user->hasRole('GESTOR') || ($user->hasRole('DESENVOLUPADOR') && $projecte->devs->contains($user->id)));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        // Solo ADMIN/GESTOR pueden borrar tickets
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}

<?php

namespace App\Models\Policies;

use App\Models\Client;
use App\Models\User;

class   ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Decide quién puede ver la lista de clientes
        // ADMIN y GESTOR pueden ver todos
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        // Quién puede ver un cliente concreto
        if ($user->hasRole('ADMIN') || $user->hasRole('GESTOR')) return true; // ADMIN/GESTOR todo
        if ($user->hasRole('CLIENT')) return $user->client_id === $client->id; // CLIENT solo su cliente
        return false; // el resto no puede
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Quién puede crear clientes
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        // Quién puede editar clientes
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        // Simplificado: solo ADMIN/GESTOR pueden borrar
        return $user->hasRole(['ADMIN','GESTOR']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Client $client): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        return false;
    }
}

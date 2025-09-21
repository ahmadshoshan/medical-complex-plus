<?php

namespace App\Policies;

use App\Models\Revenue;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RevenuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
          return $user->hasRole(['admin']) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Revenue $Revenue): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Revenue $Revenue): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Revenue $Revenue): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Revenue $Revenue): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Revenue $Revenue): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }
}

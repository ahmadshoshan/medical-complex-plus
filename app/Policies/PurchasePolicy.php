<?php

namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
          return $user->hasRole(['admin','purchases']) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Purchase $Purchase): bool
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
    public function update(User $user, Purchase $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Purchase $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Purchase $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Purchase $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }
}

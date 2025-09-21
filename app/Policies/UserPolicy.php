<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
//  public $autoReturn =    $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin','users']);
        // return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
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
    public function update(User $user, User $model): bool
    {
    //    return true;
       return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
         return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
         return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
      return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }
}

<?php

namespace App\Policies;


use App\Models\PurchaseInvoiceItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PurchaseInvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
          return $user->hasRole(['admin',' PurchaseInvoice']) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user,  PurchaseInvoiceItem $Purchase): bool
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
    public function update(User $user,  PurchaseInvoiceItem $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user,  PurchaseInvoiceItem $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user,  PurchaseInvoiceItem $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user,  PurchaseInvoiceItem $Purchase): bool
    {
          return $user->hasRole(['admin']) ||$user->hasPermissionTo(__FUNCTION__);
    }
}

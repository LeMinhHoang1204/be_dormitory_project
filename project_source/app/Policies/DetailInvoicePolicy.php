<?php

namespace App\Policies;

use App\Models\DetailInvoice;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DetailInvoicePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DetailInvoice $detailInvoice): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'accountant';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DetailInvoice $detailInvoice): bool
    {
        return $user->role === 'admin' || $user->role === 'accountant';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DetailInvoice $detailInvoice): bool
    {
        return $user->role === 'admin' || $user->role === 'accountant';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DetailInvoice $detailInvoice): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DetailInvoice $detailInvoice): bool
    {
        //
    }
}

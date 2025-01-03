<?php

namespace App\Policies;

use App\Models\Residence;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResidencePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Residence $residence): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'admin' || $user->role == 'student';
        // con TH truong toa dk dum
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Residence $residence): bool
    {
        return $user->role == 'admin' || $user->role == 'student';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Residence $residence): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Residence $residence): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Residence $residence): bool
    {
        return false;
    }
}

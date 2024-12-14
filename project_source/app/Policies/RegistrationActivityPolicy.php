<?php

namespace App\Policies;

use App\Models\RegistrationActivity;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegistrationActivityPolicy
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
    public function view(User $user, RegistrationActivity $registrationActivity): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RegistrationActivity $registrationActivity): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RegistrationActivity $registrationActivity): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RegistrationActivity $registrationActivity): bool
    {
        return false;
    }
    public function store(User $user, RegistrationActivity $registrationActivity): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager' || $user->role === 'student';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RegistrationActivity $registrationActivity): bool
    {
        return false;
    }
}

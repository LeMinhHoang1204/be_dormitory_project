<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Violation;
use Illuminate\Auth\Access\Response;

class ViolationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin'
            || $user->role === 'building manager'
            ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Violation $violation): bool
    {
        return $user->role === 'admin'
            || $user->id === $violation->creator_id
            || $user->id === $violation->receiver_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin'
            || $user->role === 'building manager';
//            || $user->role === 'accountant';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Violation $violation): bool
    {
        return $user->role === 'admin'
            || $user->role === 'building manager'
        || $user->id === $violation->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Violation $violation): bool
    {
        return $user->role === 'admin'
            || $user->id === $violation->creator_id;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Violation $violation): bool
    {
        return $user->role === 'admin'
            || $user->id === $violation->creator_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Violation $violation): bool
    {
        return $user->role === 'admin'
            || $user->id === $violation->creator_id;
    }
    public function createComplaint(User $user, Violation $violation)
    {
        return $user->role === 'student';
    }

}

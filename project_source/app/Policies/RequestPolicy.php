<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Request $request): bool
    {
        return $user->role === 'admin'
            ||$user->role === 'building manager'
            || $user->id === $request->sender_id
            || $user->id === $request->receiver_id;
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
    public function update(User $user, Request $request): bool
    {
        return $user->id === $request->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Request $request): bool
    {
        return $user->id === $request->sender_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Request $request): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Request $request): bool
    {
        return false;
    }

    public function viewAcceptRejectTransferCheckInReq(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    public function confirmRequest(User $user, Request $request): bool
    {
        return $user->role === 'admin'|| (($user->role === 'building manager' || $user->role === 'accountant')
                && $request->receiver_id === $user->id);

    }



    public function resolveRequest(User $user, Request $request): bool
    {
        return $user->role === 'admin'|| $user->role === 'building manager' || $user->role === 'accountant';
    }
}

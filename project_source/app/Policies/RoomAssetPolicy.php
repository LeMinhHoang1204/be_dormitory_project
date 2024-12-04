<?php

namespace App\Policies;

use App\Models\RoomAsset;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomAssetPolicy
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
    public function view(User $user, RoomAsset $roomAsset): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RoomAsset $roomAsset): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RoomAsset $roomAsset): bool
    {
        return $user->role === 'admin' || $user->role === 'building manager';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RoomAsset $roomAsset): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RoomAsset $roomAsset): bool
    {
        return false;
    }
}

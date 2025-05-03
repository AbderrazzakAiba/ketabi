<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Admin can view any user, and a user can view their own profile
        return $user->isAdmin() || $user->id_User === $model->id_User;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create users
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Admin can update any user, and a user can update their own profile
        return $user->isAdmin() || $user->id_User === $model->id_User;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Only Admin can delete users, and cannot delete themselves
        return $user->isAdmin() && $user->id_User !== $model->id_User;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Only Admin can restore users
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Only Admin can permanently delete users
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the status of a user.
     */
    public function updateStatus(User $user, User $model): bool
    {
        // Only Admin can update user status
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view pending users.
     */
    public function viewPending(User $user): bool
    {
        // Only Admin can view pending users
        return $user->isAdmin();
    }
}

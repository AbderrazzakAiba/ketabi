<?php

namespace App\Policies;

use App\Models\Copy;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole

class CopyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view any copy
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Copy $copy): bool
    {
        // All authenticated users can view a specific copy
        return $user !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Employees can create copies
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Copy $copy): bool
    {
        // Only Employees can update copies
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Copy $copy): bool
    {
        // Only Employees can delete copies
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Copy $copy): bool
    {
        // Only Employees can restore copies
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Copy $copy): bool
    {
        // Only Employees can permanently delete copies
        return $user->isEmployee();
    }
}

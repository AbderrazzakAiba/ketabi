<?php

namespace App\Policies;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole enum

class EmployerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only Admin can view any employers
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employer $employer): bool
    {
        // Only Admin can view a specific employer
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create employers
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employer $employer): bool
    {
        // Only Admin can update employers
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employer $employer): bool
    {
        // Only Admin can delete employers
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employer $employer): bool
    {
        // Only Admin can restore employers
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employer $employer): bool
    {
        // Only Admin can permanently delete employers
        return $user->isAdmin();
    }
}

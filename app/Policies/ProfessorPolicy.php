<?php

namespace App\Policies;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole enum

class ProfessorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow Admin and Employee to view any professors
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Professor $professor): bool
    {
        // Allow Admin, Employee, and the professor themselves to view
        return $user->isAdmin() || $user->isEmployee() || ($user->id_User === $professor->id_User);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create professors (creation is handled in UserController)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Professor $professor): bool
    {
        // Only Admin can update professors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Professor $professor): bool
    {
        // Only Admin can delete professors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Professor $professor): bool
    {
        // Only Admin can restore professors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Professor $professor): bool
    {
        // Only Admin can permanently delete professors
        return $user->isAdmin();
    }
}

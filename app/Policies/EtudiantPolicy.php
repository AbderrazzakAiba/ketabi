<?php

namespace App\Policies;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole enum

class EtudiantPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow Admin and Employee to view any students
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Etudiant $etudiant): bool
    {
        // Allow Admin, Employee, Professor, and the student themselves to view
        return $user->isAdmin() || $user->isEmployee() || $user->isProfessor() || ($user->id_User === $etudiant->id_User);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create students (creation is handled in UserController)
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Etudiant $etudiant): bool
    {
        // Only Admin can update students
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Etudiant $etudiant): bool
    {
        // Only Admin can delete students
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Etudiant $etudiant): bool
    {
        // Only Admin can restore students
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Etudiant $etudiant): bool
    {
        // Only Admin can permanently delete students
        return $user->isAdmin();
    }
}

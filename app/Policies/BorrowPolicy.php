<?php

namespace App\Policies;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole
use App\Enums\UserStatus; // Import UserStatus

class BorrowPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all borrows, other authenticated users can view their own
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Borrow $borrow): bool
    {
        // Admin can view any borrow, other users can view their own
        return $user->isAdmin() || $user->id_User === $borrow->id_User;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // All approved users can create a borrow (initiate)
        return $user->status === UserStatus::APPROVED;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Borrow $borrow): bool
    {
        // Only Employee can update a borrow
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Borrow $borrow): bool
    {
        // Only Employee can delete a borrow
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Borrow $borrow): bool
    {
        // Only Employee can restore a borrow
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Borrow $borrow): bool
    {
        // Only Employee can permanently delete a borrow
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can return a borrow.
     */
    public function returnBook(User $user, Borrow $borrow): bool
    {
        // Only Employee can return a borrow
        return $user->isEmployee();
    }
}

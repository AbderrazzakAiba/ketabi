<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole

class BookPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view any book
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Book $book): bool
    {
        // All authenticated users can view a specific book
        return $user !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Employees can create books
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Book $book): bool
    {
        // Only Employees can update books
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $book): bool
    {
        // Only Employees can delete books
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $book): bool
    {
        // Only Employees can restore books
        return $user->isEmployee();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Book $book): bool
    {
        // Only Employees can permanently delete books
        return $user->isEmployee();
    }
}

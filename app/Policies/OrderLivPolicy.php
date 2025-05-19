<?php

namespace App\Policies;

use App\Models\OrderLiv;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole enum

class OrderLivPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow Admin and Employee to view any order deliveries
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OrderLiv $orderLiv): bool
    {
        // Allow Admin and Employee to view a specific order delivery
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Allow Admin and Employee to create order deliveries
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OrderLiv $orderLiv): bool
    {
        // Allow only Admin to update order deliveries
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OrderLiv $orderLiv): bool
    {
        // Only Admin can delete order deliveries
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OrderLiv $orderLiv): bool
    {
        // Only Admin can restore order deliveries
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OrderLiv $orderLiv): bool
    {
        // Only Admin can permanently delete order deliveries
        return $user->isAdmin();
    }
}

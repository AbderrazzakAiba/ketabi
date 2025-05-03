<?php

namespace App\Policies;

use App\Models\Editor;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Enums\UserRole; // Import UserRole enum

class EditorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only Admin can view any editors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Editor $editor): bool
    {
        // Only Admin can view a specific editor
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin can create editors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Editor $editor): bool
    {
        // Only Admin can update editors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Editor $editor): bool
    {
        // Only Admin can delete editors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Editor $editor): bool
    {
        // Only Admin can restore editors
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Editor $editor): bool
    {
        // Only Admin can permanently delete editors
        return $user->isAdmin();
    }
}

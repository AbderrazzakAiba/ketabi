<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Enums\UserRole;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return !($user->role === \App\Enums\UserRole::STUDENT->value || $user->role === \App\Enums\UserRole::PROFESSOR->value);
    }
}

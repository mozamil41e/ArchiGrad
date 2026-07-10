<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class UserPolicy
{
    /**
     * Every ability on the User resource is admin-only.
     */
    public function before(User $user, string $ability): bool
    {
        return $user->role === Role::Admin;
    }
}

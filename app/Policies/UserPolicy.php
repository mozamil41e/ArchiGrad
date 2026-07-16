<?php

namespace App\Policies;


use App\Models\User;

class UserPolicy
{
    /**
     * Every ability on the User resource is admin-only.
     */
    public function before(User $user, string $ability): bool
    {
        return $user->hasRole('admin');
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }
    public function update(User $user): bool
    {
        return $user->hasRole('admin');
    }
    public function delete(User $user): bool
    {
        return $user->hasRole('admin');
    }
}

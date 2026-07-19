<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole('admin') ? true : null;
    }

    public function delete(User $user, Project $project): bool
    {
        return false; // Admin فقط عبر before()
    }

    public function create(User $user, Project $project): bool
    {
        return false;
    }

    public function archive(User $user, Project $project): bool
    {
        return $user->hasRole('admin') ? true : false;
    }

    public function unarchive(User $user, Project $project): bool
    {
        return $user->hasRole('admin') ? true : false;
    }
}

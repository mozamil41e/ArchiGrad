<?php

namespace App\Actions\Users;

use App\Enums\Role;
use App\Exceptions\UserDeletionException;
use App\Models\User;

class DeleteUser
{
    public function execute(User $user, User $actingUser): void
    {
        if ($user->is($actingUser)) {
            throw UserDeletionException::cannotDeleteSelf();
        }

        if ($user->role === Role::Admin && User::where('role', Role::Admin->value)->count() <= 1) {
            throw UserDeletionException::lastAdmin();
        }

        $user->delete();
    }
}

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
            throw new UserDeletionException('لا يمكنك حذف حسابك الخاص.');
        }

        if ($user->role === Role::Admin && User::where('role', Role::Admin->value)->count() <= 1) {
            throw new UserDeletionException('لا يمكن حذف آخر حساب مدير في النظام.');
        }

        $user->delete();
    }
}

<?php

namespace App\Exceptions;

use RuntimeException;

class UserDeletionException extends RuntimeException
{
    public static function cannotDeleteSelf(): self
    {
        return new self('لا يمكنك حذف حسابك الخاص.😒');
    }

    public static function lastAdmin(): self
    {
        return new self('لا يمكن حذف آخر حساب مدير.😒');
    }
}

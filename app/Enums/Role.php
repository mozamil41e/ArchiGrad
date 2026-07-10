<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'مدير النظام',
            self::User => 'مستخدم عادي',
        };
    }
}

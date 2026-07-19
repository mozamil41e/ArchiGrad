<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case User = 'user';

    case Supervisor = 'supervisor';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'مدير النظام',
            self::User => 'مستخدم عادي',
            self::Supervisor => 'مشرف',
        };
    }
}

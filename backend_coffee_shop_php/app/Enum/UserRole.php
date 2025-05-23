<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case BARISTA = 'barista';

    public static function values(): array
    {
        return [
            self::ADMIN->value,
            self::USER->value,
            self::BARISTA->value
        ];
    }
}

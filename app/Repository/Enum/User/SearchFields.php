<?php

namespace App\Repository\Enum\User;

enum SearchFields : string
{
    case ID = 'id';
    case NAME = 'name';
    case EMAIL = 'email';
    case IS_ACTIVE = 'is_active';

    public static function toArray(): array
    {
        return [
            'id',
            'name',
            'email',
            'is_active'
        ];
    }
}

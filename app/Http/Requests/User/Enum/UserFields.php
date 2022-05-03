<?php

namespace App\Http\Requests\User\Enum;

enum UserFields : string
{
    case ID = 'id';
    case NAME = 'name';
    case EMAIL = 'email';
    case PASSWORD = 'password';
    case ACTIVE = 'active';
    case PERMISSIONS = 'permissions';
}

<?php

namespace App\Repository\Eloquent\Model\User\Helper;

use App\Repository\Eloquent\Model\User\User;

class AddTableToUserField
{
    public static function addTableToUserField(string $field): string
    {
        return User::TABLE_NAME.".$field";
    }
}

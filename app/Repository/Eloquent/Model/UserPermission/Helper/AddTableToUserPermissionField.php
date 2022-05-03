<?php

namespace App\Repository\Eloquent\Model\UserPermission\Helper;

use App\Repository\Eloquent\Model\UserPermission\UserPermission;

class AddTableToUserPermissionField
{
    public static function addTableToUserPermissionField(string $field): string
    {
        return UserPermission::TABLE_NAME.".$field";
    }
}

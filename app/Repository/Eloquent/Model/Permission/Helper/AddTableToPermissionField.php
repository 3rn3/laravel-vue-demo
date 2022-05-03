<?php

namespace App\Repository\Eloquent\Model\Permission\Helper;

use App\Repository\Eloquent\Model\Permission\Permission;

class AddTableToPermissionField
{
    public static function addTableToPermissionField(string $field): string
    {
        return Permission::TABLE_NAME.".$field";
    }
}

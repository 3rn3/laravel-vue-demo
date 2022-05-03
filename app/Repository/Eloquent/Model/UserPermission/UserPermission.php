<?php

namespace App\Repository\Eloquent\Model\UserPermission;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    public const TABLE_NAME = 'user_permissions';
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const PERMISSION_ID = 'permission_id';
}

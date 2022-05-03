<?php

namespace App\Repository\Interfaces\Model\Permission;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

interface IRules
{
    public function uniquePermissionName(IPermission $ignorePermission = null): Unique;

    public function permissionIdExists(): Exists;
}

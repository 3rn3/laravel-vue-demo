<?php

namespace App\Repository\Eloquent\Model\Permission;



use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IRules;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

class Rules implements IRules
{
    public function uniquePermissionName(IPermission $ignorePermission = null): Unique
    {
        $rule = Rule::unique(Permission::class, Permission::NAME);

        if ($ignorePermission instanceof IPermission) {
            $rule->ignore($ignorePermission);
        }

        return $rule;
    }

    public function permissionIdExists(): Exists
    {
        return Rule::exists(Permission::class, Permission::ID);
    }

}

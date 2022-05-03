<?php

namespace App\Services\User\Implementation\Services;

use App\Services\User\Implementation\Services\Permission\Services as PermissionServices;
use App\Services\User\Implementation\Services\User\Services as UserServices;

class SubServices
{
    protected ?UserServices $userServices = null;
    protected ?PermissionServices $permissionServices = null;


    public function userServices(): UserServices
    {
        if (! $this->userServices instanceof UserServices) {
            $this->userServices = resolve(UserServices::class);
        }

        return $this->userServices;
    }

    public function permissionServices(): PermissionServices
    {
        if (! $this->permissionServices instanceof PermissionServices) {
            $this->permissionServices = resolve(PermissionServices::class);
        }

        return $this->permissionServices;
    }
}

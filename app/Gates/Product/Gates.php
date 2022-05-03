<?php

namespace App\Gates\Product;

use App\Repository\Enum\Permission\PermissionName;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Gates
{
    use HandlesAuthorization;

    public function store(IUser $user): Response
    {
        return $user->hasPermission((PermissionName::PRODUCT_WRITE)->value) ?
            $this->allow() :
            $this->deny();
    }

    public function read(IUser $user): Response
    {
        return $user->hasPermission((PermissionName::PRODUCT_READ)->value) ?
            $this->allow() :
            $this->deny();
    }
}

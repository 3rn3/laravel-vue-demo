<?php

namespace App\Gates\User;

use App\Repository\Enum\Permission\PermissionName;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class Gates
{
    use HandlesAuthorization;

    public function store(IUser $user): Response
    {
        return $user->hasPermission((PermissionName::USER_WRITE)->value) ?
            $this->allow() :
            $this->deny();
    }

    public function search(IUser $user): Response
    {
        return $user->hasPermission((PermissionName::USER_READ)->value) ?
            $this->allow() :
            $this->deny();
    }

    public function update(IUser $user, IUser $userToUpdate): Response
    {
        return $user->hasPermission((PermissionName::USER_WRITE)->value) || $user->getId() === $userToUpdate->getId() ?
            $this->allow() :
            $this->deny();
    }

    public function view(IUser $user, IUser $userToView): Response
    {
        return $user->hasPermission((PermissionName::USER_READ)->value) || $user->getId() === $userToView->getId() ?
            $this->allow() :
            $this->deny();
    }
}

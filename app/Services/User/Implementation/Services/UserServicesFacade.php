<?php

namespace App\Services\User\Implementation\Services;

use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class UserServicesFacade implements IUserServicesFacade
{
    public function __construct(protected SubServices $subServices) {}

    public function storeUser(IUserStoreDTO $userStoreDTO, int ...$permissions): IUser
    {
        return $this->subServices->userServices()->store()->store($userStoreDTO, ...$permissions);
    }

    public function updateUserName(IUser $user, string $name): void
    {
        $this->subServices->userServices()->update()->updateName($user, $name);
    }

    public function updateUserEmail(IUser $user, string $email): void
    {
        $this->subServices->userServices()->update()->updateEmail($user, $email);
    }

    public function updateUserPassword(IUser $user, string $password): void
    {
        $this->subServices->userServices()->update()->updatePassword($user, $password);
    }

    public function enableUser(IUser $user): void
    {
        $this->subServices->userServices()->update()->enable($user);
    }

    public function disableUser(IUser $user): void
    {
        $this->subServices->userServices()->update()->disable($user);
    }

    public function addUserPermission(IUser $user, IPermission $permission): void
    {
        $this->subServices->userServices()->update()->addPermission($user, $permission);
    }

    public function removeUserPermission(IUser $user, IPermission $permission): void
    {
        $this->subServices->userServices()->update()->removePermission($user, $permission);
    }

    public function syncUserPermissions(IUser $user, int ...$permissions): void
    {
        $this->subServices->userServices()->update()->syncPermissions($user, ...$permissions);
    }

    public function findUser(array $searchFields): IUser
    {
        return $this->subServices->userServices()->search()->find($searchFields);
    }

    public function searchUser(array $searchFields): Collection|Paginator
    {
        return $this->subServices->userServices()->search()->search($searchFields);
    }


    /* ----------------------------- Permission Services ------------------- */
    public function storePermission(IPermissionStoreDTO $permissionStoreDTO): IPermission
    {
        return $this->subServices->permissionServices()->store()->store($permissionStoreDTO);
    }

    public function updatePermissionDisplayLabel(IPermission $permission, string $displayLabel): void
    {
        $this->subServices->permissionServices()->update()->updateDisplayLabel($permission, $displayLabel);
    }

    public function findPermission(array $searchFields): IPermission
    {
        return $this->subServices->permissionServices()->search()->find($searchFields);
    }

    public function searchPermissions(array $searchFields): Collection|Paginator
    {
        return $this->subServices->permissionServices()->search()->search($searchFields);
    }

}

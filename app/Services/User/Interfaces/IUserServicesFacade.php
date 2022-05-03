<?php

namespace App\Services\User\Interfaces;

use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface IUserServicesFacade
{
    public function storeUser(IUserStoreDTO $userStoreDTO, int ...$permissions): IUser;

    public function updateUserName(IUser $user, string $name): void;

    public function updateUserEmail(IUser $user, string $email): void;

    public function updateUserPassword(IUser $user, string $password): void;

    public function enableUser(IUser $user): void;

    public function disableUser(IUser $user): void;

    public function addUserPermission(IUser $user, IPermission $permission): void;

    public function removeUserPermission(IUser $user, IPermission $permission): void;

    public function syncUserPermissions(IUser $user, int ...$permissions): void;

    /**
     * @param array $searchFields
     * @return IUser
     * @throws ObjectNotFoundException
     */
    public function findUser(array $searchFields): IUser;

    /**
     * @param array $searchFields
     * @return Collection<IUser> | Paginator<IUser>
     */
    public function searchUser(array $searchFields): Collection | Paginator;


    /* -------------------- Permissions Services --------------------- */
    public function storePermission(IPermissionStoreDTO $permissionStoreDTO): IPermission;

    public function updatePermissionDisplayLabel(IPermission $permission, string $displayLabel): void;

    /**
     * @param array $searchFields
     * @return IPermission
     * @throws ObjectNotFoundException
     */
    public function findPermission(array $searchFields): IPermission;

    /**
     * @param array $searchFields
     * @return Collection<IPermission> | Paginator<IPermission>
     */
    public function searchPermissions(array $searchFields): Collection | Paginator;
}

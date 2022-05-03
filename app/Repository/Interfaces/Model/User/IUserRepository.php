<?php

namespace App\Repository\Interfaces\Model\User;

use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function store(IUserStoreDTO $userStoreDTO): IUser;

    public function updateName(IUser $user, string $name): void;

    public function updateEmail(IUser $user, string $email): void;

    public function updatePassword(IUser $user, string $password): void;

    public function enable(IUser $user): void;

    public function disable(IUser $user): void;

    public function addPermission(IUser $user, IPermission $permission): void;

    public function removePermission(IUser $user, IPermission $permission): void;

    public function syncPermissions(IUser $user, int ...$permissions): void;

    /**
     * @param array $searchFields
     * @return IUser
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IUser;

    /**
     * @param array $searchFields
     * @return Paginator<IUser> | Collection<IUser>
     */
    public function search(array $searchFields): Paginator | Collection;
}

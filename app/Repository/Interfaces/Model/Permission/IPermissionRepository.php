<?php

namespace App\Repository\Interfaces\Model\Permission;

use App\Repository\Exceptions\ObjectNotFoundException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface IPermissionRepository
{
    public function store(IPermissionStoreDTO $permissionStoreDTO): IPermission;

    public function updateDisplayLabel(IPermission $permission, string $displayLabel): void;

    /**
     * @param array $searchFields
     * @return IPermission
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IPermission;

    /**
     * @param array $searchFields
     * @return Paginator<IPermission> | Collection<IPermission>
     */
    public function search(array $searchFields): Paginator | Collection;
}

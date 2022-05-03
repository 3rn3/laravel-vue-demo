<?php

namespace App\Services\User\Implementation\Services\Permission;

use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class Search
{
    public function __construct(protected IPermissionRepository $permissionRepository) {}

    /**
     * @param array $searchFields
     * @return Collection|Paginator
     */
    public function search(array $searchFields): Collection | Paginator
    {
        return $this->permissionRepository->search($searchFields);
    }

    /**
     * @param array $searchFields
     * @return IPermission
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IPermission
    {
        return $this->permissionRepository->find($searchFields);
    }
}

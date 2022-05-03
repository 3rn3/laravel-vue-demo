<?php

namespace App\Services\User\Implementation\Services\Permission;

use App\Repository\Enum\Permission\SearchFields;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionRepository;
use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;

class Store
{
    public function __construct(protected IPermissionRepository $permissionRepository) {}

    public function store(IPermissionStoreDTO $permissionStoreDTO): IPermission
    {
        try {
            return $this->permissionRepository->find([
                (SearchFields::NAME)->value => $permissionStoreDTO->uniqueName()
            ]);
        }catch (ObjectNotFoundException $objectNotFoundException) {
            return $this->permissionRepository->store($permissionStoreDTO);
        }
    }
}

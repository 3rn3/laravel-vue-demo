<?php

namespace App\Services\User\Implementation\Services\Permission;

use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionRepository;

class Update
{
    public function __construct(protected IPermissionRepository $permissionRepository) {}

    public function updateDisplayLabel(IPermission $permission, string $displayLabel): void
    {
        $this->permissionRepository->updateDisplayLabel($permission, $displayLabel);
    }
}

<?php

namespace App\Repository\Interfaces\Model\Permission;

interface IPermissionStoreDTO
{
    public function uniqueName(): string;

    public function displayLabel(): string;
}

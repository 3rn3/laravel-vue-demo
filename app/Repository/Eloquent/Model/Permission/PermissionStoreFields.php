<?php

namespace App\Repository\Eloquent\Model\Permission;

use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;

class PermissionStoreFields
{
    public function toArray(IPermissionStoreDTO $permissionStoreDTO): array
    {
        $fields = [];

        $this->addUniqueName($permissionStoreDTO->uniqueName(), $fields);
        $this->addDisplayLabel($permissionStoreDTO->displayLabel(), $fields);

        return $fields;
    }

    public function addUniqueName(string $uniqueName, array &$fields): void
    {
        $fields[Permission::NAME] = $uniqueName;
    }


    public function addDisplayLabel(string $displayLabel, array &$fields): void
    {
        $fields[Permission::DISPLAY_LABEL] = $displayLabel;
    }
}

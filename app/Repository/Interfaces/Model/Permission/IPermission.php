<?php

namespace App\Repository\Interfaces\Model\Permission;

interface IPermission
{
    public function getId(): int;

    public function getUniqueName(): string;

    public function getDisplayLabel(): string;
}

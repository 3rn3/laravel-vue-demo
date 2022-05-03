<?php

namespace App\Repository\Eloquent\Model\Permission\Pipeline\Search\Pipes;

use App\Repository\Eloquent\Model\Permission\Helper\AddTableToPermissionField;
use App\Repository\Eloquent\Model\Permission\Permission;
use App\Repository\Eloquent\Pipeline\Search\Passable;
use App\Repository\Eloquent\Pipeline\Search\Pipes\SearchPipe;
use App\Repository\Enum\Permission\SearchFields;

class Name extends SearchPipe
{
    protected function searchFieldName(): string
    {
        return (SearchFields::NAME)->value;
    }

    protected function addConditionToBuilder(Passable $passable)
    {
        $this->whereCondition($passable, AddTableToPermissionField::addTableToPermissionField(Permission::NAME));
    }

}

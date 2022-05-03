<?php

namespace App\Repository\Eloquent\Model\User\Pipeline\Search\Pipes;


use App\Repository\Eloquent\Model\User\Helper\AddTableToUserField;
use App\Repository\Eloquent\Model\User\User;
use App\Repository\Eloquent\Pipeline\Search\Passable;
use App\Repository\Eloquent\Pipeline\Search\Pipes\SearchPipe;
use App\Repository\Enum\User\SearchFields;

class Id extends SearchPipe
{
    protected function searchFieldName(): string
    {
        return (SearchFields::ID)->value;
    }

    protected function addConditionToBuilder(Passable $passable)
    {
        $this->whereCondition($passable, AddTableToUserField::addTableToUserField(User::ID));
    }
}

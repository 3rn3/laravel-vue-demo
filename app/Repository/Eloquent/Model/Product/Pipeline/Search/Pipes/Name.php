<?php

namespace App\Repository\Eloquent\Model\Product\Pipeline\Search\Pipes;

use App\Repository\Eloquent\Model\Product\Helper\AddTableToProductField;
use App\Repository\Eloquent\Model\Product\Product;
use App\Repository\Eloquent\Pipeline\Search\Passable;
use App\Repository\Eloquent\Pipeline\Search\Pipes\SearchPipe;
use App\Repository\Enum\Product\SearchFields;

class Name  extends SearchPipe
{
    protected function searchFieldName(): string
    {
        return (SearchFields::NAME)->value;
    }

    protected function addConditionToBuilder(Passable $passable)
    {
        $this->whereCondition($passable, AddTableToProductField::addTableToProductField(Product::NAME));
    }
}

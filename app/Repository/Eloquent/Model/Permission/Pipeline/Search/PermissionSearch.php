<?php

namespace App\Repository\Eloquent\Model\Permission\Pipeline\Search;

use App\Repository\Eloquent\Model\Permission\Permission;
use App\Repository\Eloquent\Model\Permission\Pipeline\Search\Pipes\DisplayLabel;
use App\Repository\Eloquent\Model\Permission\Pipeline\Search\Pipes\Id;
use App\Repository\Eloquent\Model\Permission\Pipeline\Search\Pipes\Name;
use App\Repository\Eloquent\Pipeline\Search\Search;
use App\Repository\Exceptions\ObjectNotFoundException;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PermissionSearch extends Search
{
    public function find(Builder $builder, array $searchFields): Permission
    {
        $builder->select($this->selectFields());

        $this->builderSetup($this->createPassable($builder, $searchFields));

        $permission = $builder->first();

        return $permission instanceof Permission
            ? $permission
            : throw new ObjectNotFoundException("Permission Not Found");
    }

    protected function selectFields(): string
    {
        return Permission::TABLE_NAME.".*";
    }

    protected function pipes(): array
    {
        return [
            Id::class,
            Name::class,
            DisplayLabel::class,
        ];
    }

}

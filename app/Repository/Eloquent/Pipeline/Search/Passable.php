<?php

namespace App\Repository\Eloquent\Pipeline\Search;

use Illuminate\Contracts\Database\Eloquent\Builder;

class Passable
{
    public function __construct(protected Builder $builder, protected array $searchFields){}

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    /**
     * @return array
     */
    public function getSearchFields(): array
    {
        return $this->searchFields;
    }
}

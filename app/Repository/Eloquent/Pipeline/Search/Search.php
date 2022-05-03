<?php

namespace App\Repository\Eloquent\Pipeline\Search;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

abstract class Search
{

    public function __construct(protected Pipeline $pipeline) {}

    public function search(Builder $builder, array $searchFields): Paginator | Collection
    {
        $builder->select($this->selectFields());

        $this->builderSetup($this->createPassable($builder, $searchFields));

        return $builder->paginate();
    }

    public function builderSetup(Passable $passable): void
    {
        $this->pipeline->send($passable)
            ->through($this->pipes())
            ->thenReturn();
    }

    protected function createPassable(Builder $builder, array $fields): Passable
    {
        return new Passable($builder, $fields);
    }

    abstract protected function selectFields(): string;
    abstract protected function pipes(): array;
}

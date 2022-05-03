<?php

namespace App\Repository\Eloquent\Pipeline\Search\Pipes;

use App\Repository\Eloquent\Pipeline\Search\Passable;
use Closure;
use Illuminate\Support\Arr;

abstract class SearchPipe
{
    public function handle(Passable $passable, Closure $next)
    {
        if ($this->fieldIsPresent($passable)) {
            $this->addConditionToBuilder($passable);
        }

        return $next($passable);
    }

    protected function fieldIsPresent(Passable $passable): bool
    {
        return Arr::has($passable->getSearchFields(), $this->searchFieldName());
    }

    protected function whereCondition(Passable $passable, string $dbField): void
    {
        $passable->getBuilder()->where($dbField, '=', $passable->getSearchFields()[$this->searchFieldName()]);
    }

    abstract protected function searchFieldName(): string;

    abstract protected function addConditionToBuilder(Passable $passable);
}

<?php

namespace App\Repository\Eloquent\Model\User\Pipeline\Search;

use App\Repository\Eloquent\Model\User\Pipeline\Search\Pipes\Email;
use App\Repository\Eloquent\Model\User\Pipeline\Search\Pipes\Id;
use App\Repository\Eloquent\Model\User\Pipeline\Search\Pipes\IsActive;
use App\Repository\Eloquent\Model\User\Pipeline\Search\Pipes\Name;
use App\Repository\Eloquent\Model\User\User;
use App\Repository\Eloquent\Pipeline\Search\Search;
use App\Repository\Exceptions\ObjectNotFoundException;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserSearch extends Search
{
    public function find(Builder $builder, array $searchFields): User
    {
        $builder->select($this->selectFields());

        $this->builderSetup($this->createPassable($builder, $searchFields));

        $user = $builder->first();

        return $user instanceof User
            ? $user
            : throw new ObjectNotFoundException("User Not Found");
}

    protected function selectFields(): string
    {
        return User::TABLE_NAME.".*";
    }

    protected function pipes(): array
    {
        return [
            Id::class,
            Email::class,
            Name::class,
            IsActive::class,
        ];
    }

}

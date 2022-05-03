<?php

namespace App\Services\User\Implementation\Services\User;

use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class Search
{
    public function __construct(protected IUserRepository $userRepository) {}

    public function search(array $searchFields): Paginator | Collection
    {
        return $this->userRepository->search($searchFields);
    }

    /**
     * @param array $searchFields
     * @return IUser
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IUser
    {
        return $this->userRepository->find($searchFields);
    }
}

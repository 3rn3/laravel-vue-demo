<?php

namespace App\Services\User\Implementation\Services\User;

use App\Repository\Enum\Permission\SearchFields;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserRepository;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use App\Services\User\Implementation\Services\SubServices;
use Throwable;

class Store
{
    public function __construct(protected SubServices $subServices, protected IUserRepository $userRepository) {}

    public function store(IUserStoreDTO $userStoreDTO, int ...$permissions): IUser
    {
        $user = $this->userRepository->store($userStoreDTO);

        $this->setupPermissions($user, ...$permissions);

        return $user;
    }

    protected function setupPermissions(IUser $user, int ...$permissions): void
    {
        $permissionIdKey = (SearchFields::ID)->value;

        foreach ($permissions as $permissionId) {
            try {
                $this->userRepository->addPermission(
                    $user,
                    $this->subServices->permissionServices()
                        ->search()
                        ->find([$permissionIdKey => $permissionId]));
            }catch (Throwable $exception)
            {

            }
        }
    }
}

<?php

namespace App\Services\User\Implementation\Services\User;

use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserRepository;

class Update
{
    public function __construct(protected IUserRepository $userRepository) {}

    public function updateName(IUser $user, string $name): void
    {
        $this->userRepository->updateName($user, $name);
    }

    public function updateEmail(IUser $user, string $email): void
    {
        $this->userRepository->updateEmail($user, $email);
    }

    public function updatePassword(IUser $user, string $password): void
    {
        $this->userRepository->updatePassword($user, $password);
    }

    public function enable(IUser $user): void
    {
        $this->userRepository->enable($user);
    }

    public function disable(IUser $user): void
    {
        $this->userRepository->disable($user);
    }

    public function addPermission(IUser $user, IPermission $permission): void
    {
        $this->userRepository->addPermission($user, $permission);
    }

    public function removePermission(IUser $user, IPermission $permission): void
    {
        $this->userRepository->removePermission($user, $permission);
    }

    public function syncPermissions(IUser $user, int ...$permissions): void
    {
        $this->userRepository->syncPermissions($user, ...$permissions);
    }
}

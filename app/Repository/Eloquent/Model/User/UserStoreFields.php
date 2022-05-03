<?php

namespace App\Repository\Eloquent\Model\User;

use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use Illuminate\Support\Facades\Hash;

class UserStoreFields
{
    public function toArray(IUserStoreDTO $userStoreDTO): array
    {
        $fields = [];

        $this->addName($userStoreDTO->name(), $fields);
        $this->addEmail($userStoreDTO->email(), $fields);
        $this->addPassword($userStoreDTO->password(), $fields);
        $this->addIsActive(true, $fields);

        return $fields;
    }

    public function addName(string $name, array &$fields): void
    {
        $fields[User::NAME] = $name;
    }

    public function addEmail(string $email, array &$fields): void
    {
        $fields[User::EMAIL] = $email;
    }

    public function addPassword(string $password, array &$fields): void
    {
        $fields[User::PASSWORD] = Hash::make($password);
    }

    public function addIsActive(bool $isActive, array &$fields): void
    {
        $fields[User::ACTIVE] = $isActive;
    }
}

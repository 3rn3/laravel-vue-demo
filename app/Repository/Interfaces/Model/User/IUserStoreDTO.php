<?php

namespace App\Repository\Interfaces\Model\User;

interface IUserStoreDTO
{
    public function name(): string;

    public function email(): string;

    public function password(): string;

    public function isActive(): bool;
}

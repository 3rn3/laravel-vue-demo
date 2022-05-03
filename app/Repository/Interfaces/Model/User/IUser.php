<?php

namespace App\Repository\Interfaces\Model\User;

use Illuminate\Support\Collection;

interface IUser
{
    public function getId(): int;

    public function getName(): string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function isActive(): bool;

    public function hasPermission(string $permission): bool;

    public function getPermissions(): Collection;
}

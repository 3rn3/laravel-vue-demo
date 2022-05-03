<?php

namespace App\Gates\Traits;

use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

trait GateTrait
{
    public static function inspect(string $ability, array $arguments, IUser $user = null): Response
    {
        if ($user instanceof IUser) {
            return Gate::forUser($user)->inspect($ability, $arguments);
        }

        return Gate::inspect($ability, $arguments);
    }
}

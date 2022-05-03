<?php

namespace App\Gates\User;

use App\Gates\Traits\GateTrait;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Auth\Access\Response;

class GateInspect
{
    use GateTrait;

    public static function inspect_STORE(IUser $user = null): Response
    {
        return self::inspect((GateNames::STORE)->value, [], $user);
    }

    public static function inspect_SEARCH(IUser $user = null): Response
    {
        return self::inspect((GateNames::SEARCH)->value, [], $user);
    }

    public static function inspect_VIEW(IUser $userToView, IUser $user = null): Response
    {
        return self::inspect((GateNames::VIEW)->value, [$userToView], $user);
    }

    public static function inspect_UPDATE(IUser $userToUpdate, IUser $user = null): Response
    {
        return self::inspect((GateNames::UPDATE)->value, [$userToUpdate], $user);
    }
}

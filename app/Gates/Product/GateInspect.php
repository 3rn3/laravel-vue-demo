<?php

namespace App\Gates\Product;

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

    public static function inspect_READ(IUser $user = null): Response
    {
        return self::inspect((GateNames::READ)->value, [], $user);
    }
}

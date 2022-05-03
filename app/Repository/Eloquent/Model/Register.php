<?php

namespace App\Repository\Eloquent\Model;

use App\Repository\Eloquent\Model\Permission\Register as PermissionRegister;
use App\Repository\Eloquent\Model\Product\Register as ProductRegister;
use App\Repository\Eloquent\Model\User\Register as UserRegister;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        PermissionRegister::register($application);
        ProductRegister::register($application);
        UserRegister::register($application);
    }
}

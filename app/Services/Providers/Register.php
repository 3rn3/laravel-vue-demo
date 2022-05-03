<?php

namespace App\Services\Providers;

use App\Services\Product\Providers\Register as ProductServicesRegister;
use App\Services\User\Providers\Register as UserServicesRegister;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        UserServicesRegister::register($application);
        ProductServicesRegister::register($application);
    }
}

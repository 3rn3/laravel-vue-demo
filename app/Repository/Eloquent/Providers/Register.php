<?php

namespace App\Repository\Eloquent\Providers;

use App\Repository\Eloquent\Model\Register as ModelRegister;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        ModelRegister::register($application);
    }
}

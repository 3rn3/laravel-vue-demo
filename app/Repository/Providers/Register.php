<?php

namespace App\Repository\Providers;

use App\Repository\Eloquent\Providers\Register as EloquentRegister;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        EloquentRegister::register($application);
    }
}

<?php

namespace App\Services\User\Providers;

use App\Services\User\Implementation\Services\UserServicesFacade;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        $application->bind(IUserServicesFacade::class, UserServicesFacade::class);
    }
}

<?php

namespace App\Repository\Eloquent\Model\User;

use App\Repository\Interfaces\Model\User\IRules;
use App\Repository\Interfaces\Model\User\IUserRepository;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        $application->bind(IUserRepository::class, UserRepository::class);;
        $application->bind(IRules::class, Rules::class);;
    }
}

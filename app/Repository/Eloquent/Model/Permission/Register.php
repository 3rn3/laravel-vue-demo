<?php

namespace App\Repository\Eloquent\Model\Permission;

use App\Repository\Interfaces\Model\Permission\IPermissionRepository;
use App\Repository\Interfaces\Model\Permission\IRules;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        $application->bind(IPermissionRepository::class, PermissionRepository::class);
        $application->bind(IRules::class, Rules::class);
    }
}

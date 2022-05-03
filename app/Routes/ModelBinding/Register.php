<?php

namespace App\Routes\ModelBinding;

use App\Routes\ModelBinding\Product\Register as ProductBindRegister;
use App\Routes\ModelBinding\User\Register as UserBindRegister;

class Register
{
    public static function boot(): void
    {
        UserBindRegister::boot();
        ProductBindRegister::boot();
    }
}

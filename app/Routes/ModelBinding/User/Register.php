<?php

namespace App\Routes\ModelBinding\User;

class Register
{
    public static function boot(): void
    {
        RouteBind::bind();
    }
}

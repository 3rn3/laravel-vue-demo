<?php

namespace App\Gates\Product;

use Illuminate\Support\Facades\Gate;

class GateRegister
{
    public static function boot(): void
    {
        Gate::define((GateNames::STORE)->value, [Gates::class, 'store']);
        Gate::define((GateNames::READ)->value, [Gates::class, 'read']);
    }
}

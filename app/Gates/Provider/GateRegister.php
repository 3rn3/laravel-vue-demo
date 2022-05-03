<?php

namespace App\Gates\Provider;

use App\Gates\Product\GateRegister as ProductGateRegister;
use App\Gates\User\GateRegister as UserGateRegister;

class GateRegister
{
    public static function boot(): void
    {
        UserGateRegister::boot();
        ProductGateRegister::boot();
    }
}

<?php

namespace App\Gates\User;

use Illuminate\Support\Facades\Gate;

class GateRegister
{
    public static function boot(): void
    {
        Gate::define((GateNames::STORE)->value, [Gates::class, 'store']);
        Gate::define((GateNames::SEARCH)->value, [Gates::class, 'search']);
        Gate::define((GateNames::VIEW)->value, [Gates::class, 'view']);
        Gate::define((GateNames::UPDATE)->value, [Gates::class, 'update']);

    }
}

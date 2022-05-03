<?php

namespace App\Services\Product\Providers;

use App\Services\Product\Implementation\Services\ProductServicesFacade;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        $application->bind(IProductServicesFacade::class, ProductServicesFacade::class);
    }
}

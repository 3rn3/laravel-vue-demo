<?php

namespace App\Routes\Routes;

use App\Routes\Routes\Dashboard\DashboardRoutes;
use App\Routes\Routes\Product\ProductRoutes;
use App\Routes\Routes\User\UserRoutes;
use Illuminate\Support\Facades\Route;

class Auth
{

    public static function routes(): void
    {
        Route::middleware(['auth'])->group(static function() {
            DashboardRoutes::routes();
            UserRoutes::routes();
            ProductRoutes::routes();
        });
    }


}

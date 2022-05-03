<?php

namespace App\Routes\Routes\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

class DashboardRoutes
{
    public static function routes(): void
    {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
    }
}

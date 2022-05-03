<?php

namespace App\Routes\Routes\User;

use App\Http\Controllers\User\Search\SearchController;
use App\Http\Controllers\User\Search\SearchUIController;
use App\Http\Controllers\User\Store\StoreController;
use App\Http\Controllers\User\Store\StoreUIController;
use App\Http\Controllers\User\Update\UpdateController;
use App\Http\Controllers\User\Update\UpdateUIController;
use App\Http\Middleware\MiddlewareNames\User;
use App\Routes\RouteKey;
use Illuminate\Support\Facades\Route;

class UserRoutes
{
    public static function routes(): void
    {
        Route::prefix('user')->name('user.')->group(static function() {
            Route::get('register', [StoreUIController::class, 'register'])
                ->name('register')
                ->middleware([User::STORE]);

            Route::post('store', [StoreController::class, 'store'])
                ->name('store')
                ->middleware([User::STORE]);

            Route::get('edit/{'.(RouteKey::USER_ID)->value.'}', [UpdateUIController::class, 'edit'])
                ->name('edit')
                ->middleware([User::UPDATE]);

            Route::prefix('update')->name('update.')->group(static function() {
                Route::put('name/{'.(RouteKey::USER_ID)->value.'}', [UpdateController::class, 'updateName'])
                    ->name('name')
                    ->middleware([User::UPDATE]);

                Route::put('email/{'.(RouteKey::USER_ID)->value.'}', [UpdateController::class, 'updateEmail'])
                    ->name('email')
                    ->middleware([User::UPDATE]);

                Route::put('password/{'.(RouteKey::USER_ID)->value.'}', [UpdateController::class, 'updatePassword'])
                    ->name('password')
                    ->middleware([User::UPDATE]);

                Route::put('permission/{'.(RouteKey::USER_ID)->value.'}', [UpdateController::class, 'updatePermissions'])
                    ->name('permission')
                    ->middleware([User::UPDATE]);
            });

            Route::get('users', [SearchUIController::class, 'users'])
                ->name('users')
                ->middleware([User::SEARCH]);

            Route::get('search', [SearchController::class, 'search'])
                ->name('search')
                ->middleware([User::SEARCH]);

            Route::get('view/{'.(RouteKey::USER_ID)->value.'}', [SearchController::class, 'view'])
                ->name('view')
                ->middleware([User::VIEW]);
        });
    }
}

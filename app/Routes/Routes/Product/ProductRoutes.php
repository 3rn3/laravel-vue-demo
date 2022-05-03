<?php

namespace App\Routes\Routes\Product;

use App\Http\Controllers\Product\Search\SearchController;
use App\Http\Controllers\Product\Search\SearchUIController;
use App\Http\Controllers\Product\Store\StoreController;
use App\Http\Controllers\Product\Update\UpdateController;
use App\Http\Middleware\MiddlewareNames\Product;
use App\Routes\RouteKey;
use Illuminate\Support\Facades\Route;

class ProductRoutes
{
    public static function routes(): void
    {
        Route::prefix('product')->name('product.')->group(static function() {
            Route::post('store', [StoreController::class, 'store'])
                ->name('store')
                ->middleware([Product::STORE]);

            Route::prefix('update')->name('update.')->group(static function() {
                Route::put('price/{'.(RouteKey::PRODUCT_ID)->value.'}', [UpdateController::class, 'updatePrice'])
                    ->name('price')
                    ->middleware([Product::STORE]);

                Route::put('status/{'.(RouteKey::PRODUCT_ID)->value.'}', [UpdateController::class, 'updateStatus'])
                    ->name('status')
                    ->middleware([Product::STORE]);
            });

            Route::get('products', [SearchUIController::class, 'products'])
                ->name('products')
                ->middleware([Product::READ]);

            Route::get('search', [SearchController::class, 'search'])
                ->name('search')
                ->middleware([Product::READ]);

            Route::get('view/{'.(RouteKey::PRODUCT_ID)->value.'}', [SearchController::class, 'view'])
                ->name('search')
                ->middleware([Product::READ]);
        });
    }
}

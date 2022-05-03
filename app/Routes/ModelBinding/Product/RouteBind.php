<?php

namespace App\Routes\ModelBinding\Product;

use App\Repository\Enum\Product\SearchFields;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Routes\RouteKey;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Throwable;

class RouteBind
{
    public static function bind(): void
    {
        Route::bind((RouteKey::PRODUCT_ID)->value, static function($value): IProduct {
            try {
                return self::productServicesFacade()->findProduct([(SearchFields::ID)->value => $value]);
            }catch (Throwable $exception)
            {

            }

            abort(Response::HTTP_NOT_FOUND);
        });
    }

    protected static function productServicesFacade(): IProductServicesFacade
    {
        return resolve(IProductServicesFacade::class);
    }
}

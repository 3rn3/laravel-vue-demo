<?php

namespace App\Routes\ModelBinding\User;

use App\Repository\Enum\User\SearchFields;
use App\Repository\Interfaces\Model\User\IUser;
use App\Routes\RouteKey;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Throwable;

class RouteBind
{
    public static function bind(): void
    {
        Route::bind((RouteKey::USER_ID)->value, static function($value): IUser {
            try {
                return self::userServicesFacade()->findUser([(SearchFields::ID)->value => $value]);
            }catch (Throwable $exception) {

            }

            abort(Response::HTTP_NOT_FOUND);
        });
    }

    protected static function userServicesFacade(): IUserServicesFacade
    {
        return resolve(IUserServicesFacade::class);
    }

}

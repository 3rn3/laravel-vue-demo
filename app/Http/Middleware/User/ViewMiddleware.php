<?php

namespace App\Http\Middleware\User;

use App\Gates\User\GateInspect;
use App\Repository\Interfaces\Model\User\IUser;
use App\Routes\RouteKey;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ViewMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route((RouteKey::USER_ID)->value);

        if ($user instanceof IUser && self::authorize($user)) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }

    public static function authorize(IUser $user): bool
    {
        try {
            return GateInspect::inspect_VIEW($user)->allowed();
        }catch (Throwable $exception)
        {
            return false;
        }
    }
}

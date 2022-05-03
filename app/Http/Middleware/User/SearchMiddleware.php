<?php

namespace App\Http\Middleware\User;

use App\Gates\User\GateInspect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class SearchMiddleware
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
        if (self::authorize()) {
            return $next($request);
        }

        return abort(Response::HTTP_FORBIDDEN);
    }

    public static function authorize(): bool
    {
        try {
            return GateInspect::inspect_SEARCH()->allowed();
        }catch (Throwable $exception)
        {
            return false;
        }
    }
}

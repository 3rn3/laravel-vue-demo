<?php

namespace App\Http\Middleware\Product;

use App\Gates\Product\GateInspect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class ReadMiddleware
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
            return GateInspect::inspect_READ()->allowed();
        }catch (Throwable $exception)
        {
            return false;
        }
    }
}

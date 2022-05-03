<?php

namespace App\Http\Middleware;

use App\Gates\Product\GateInspect as ProductGateInspect;
use App\Gates\User\GateInspect as UserGateInspect;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'can' => [
                    'view_users' => UserGateInspect::inspect_SEARCH()->allowed(),
                    'register_user' => UserGateInspect::inspect_STORE()->allowed(),
                    'view_products' => ProductGateInspect::inspect_READ()->allowed()
                ],

            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
        ]);
    }
}

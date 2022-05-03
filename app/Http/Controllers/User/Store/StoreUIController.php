<?php

namespace App\Http\Controllers\User\Store;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionResource;
use App\Services\User\Interfaces\IUserServicesFacade;
use Inertia\Inertia;
use Inertia\Response;

class StoreUIController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    /**
     * Display the registration view.
     *
     * @return Response
     */
    public function register(): Response
    {
        return Inertia::render('User/Register',[
            'permissions' => PermissionResource::collection($this->userServicesFacade->searchPermissions([]))
        ]);
    }
}

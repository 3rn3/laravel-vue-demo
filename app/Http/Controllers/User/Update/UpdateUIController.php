<?php

namespace App\Http\Controllers\User\Update;

use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\User\UserResource;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UpdateUIController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    /**
     * Display the registration view.
     *
     * @return Response
     */
    public function edit(IUser $user): Response
    {
        return Inertia::render('User/Edit',[
            'user' => new UserResource($user),
            'user_permissions' => PermissionResource::collection($user->getPermissions()),
            'permissions' => PermissionResource::collection($this->userServicesFacade->searchPermissions([]))
        ]);
    }
}

<?php

namespace App\Http\Controllers\User\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchUIController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    public function users(): Response
    {
        return Inertia::render('User/Users', [
            'users' => UserResource::collection($this->userServicesFacade->searchUser([]))
        ]);
    }
}

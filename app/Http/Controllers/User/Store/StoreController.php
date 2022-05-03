<?php

namespace App\Http\Controllers\User\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class StoreController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    public function store(StoreRequest $storeRequest): JsonResponse
    {
        try {
            return (new UserResource($this->userServicesFacade->storeUser($storeRequest->userStoreDTO(), ...$storeRequest->permissions())))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

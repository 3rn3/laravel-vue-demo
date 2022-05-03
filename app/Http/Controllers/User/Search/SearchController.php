<?php

namespace App\Http\Controllers\User\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SearchRequest;
use App\Http\Resources\User\UserResource;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

class SearchController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    public function search(SearchRequest $searchRequest): JsonResponse | AnonymousResourceCollection
    {
        try {
            return UserResource::collection(
                $this->userServicesFacade->searchUser($searchRequest->getSearchFields())
            );
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }

    public function view(IUser $user): JsonResponse|UserResource
    {
        try {
            return new UserResource($user);
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

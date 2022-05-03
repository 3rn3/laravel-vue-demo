<?php

namespace App\Http\Controllers\User\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PermissionSyncRequest;
use App\Http\Requests\User\UpdateEmailRequest;
use App\Http\Requests\User\UpdateNameRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class UpdateController extends Controller
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    public function updateName(IUser $user, UpdateNameRequest $updateNameRequest): JsonResponse
    {
        return $this->makeUpdate(function () use ($user, $updateNameRequest){
            $this->userServicesFacade->updateUserName($user, $updateNameRequest->name());
        });
    }

    public function updateEmail(IUser $user, UpdateEmailRequest $updateEmailRequest): JsonResponse
    {
        return $this->makeUpdate(function () use ($user, $updateEmailRequest){
            $this->userServicesFacade->updateUserName($user, $updateEmailRequest->email());
        });
    }

    public function updatePassword(IUser $user, UpdatePasswordRequest $updatePasswordRequest): JsonResponse
    {
        return $this->makeUpdate(function () use ($user, $updatePasswordRequest) {
            $this->userServicesFacade->updateUserPassword($user, $updatePasswordRequest->password());
        });
    }

    public function updatePermissions(IUser $user, PermissionSyncRequest $permissionSyncRequest): JsonResponse
    {
        return $this->makeUpdate(function () use ($user, $permissionSyncRequest) {
            $this->userServicesFacade->syncUserPermissions($user, ...$permissionSyncRequest->permissions());
        });
    }


    protected function makeUpdate(Closure $updateClosure): JsonResponse
    {
        try {
            $updateClosure();
            return new JsonResponse('', Response::HTTP_NO_CONTENT);
        }catch (Throwable $exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

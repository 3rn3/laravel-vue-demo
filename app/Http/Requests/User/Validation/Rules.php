<?php

namespace App\Http\Requests\User\Validation;

use App\Repository\Interfaces\Model\Permission\IRules as IPermissionRules;
use App\Repository\Interfaces\Model\User\IRules as IUserRules;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Validation\Rules\Password;

class Rules
{
    public function __construct(protected IUserRules $userRules, protected IPermissionRules $permissionRules) {}

    public function name_rules(IUser $user = null): array
    {
        return [
            'required',
            'string',
            'max:255',
        ];
    }

    public function email_rules(IUser $user = null): array
    {
        return [
          'required',
          'string',
          'email',
          'max:255',
          $this->userRules->uniqueEmail($user)
        ];
    }

    public function password_rules(): array
    {
        return [
            'required',
            'confirmed',
            Password::defaults()
        ];
    }

    public function permissions_rules(): array
    {
        return [
            'required',
            'array'
        ];
    }

    public function permission_item_rules(): array
    {
        return [
            'required',
            'integer',
            $this->permissionRules->permissionIdExists()
        ];
    }
}

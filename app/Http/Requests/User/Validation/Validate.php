<?php

namespace App\Http\Requests\User\Validation;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Http\Request;

class Validate
{
    public function __construct(private readonly Rules $rules) {}

    public function userStoreValidate(Request $request): array
    {
        $rules = [];

        $this->addNameRules($rules);
        $this->addEmailRules($rules);
        $this->addPasswordRules($rules);
        $this->addPermissionsRules($request, $rules);

        return $rules;
    }

    public function addNameRules(array &$rules): void
    {
        $rules[(UserFields::NAME)->value] =  $this->rules->name_rules();
    }

    public function addEmailRules(array &$rules, IUser $user = null): void
    {
        $rules[(UserFields::EMAIL)->value] =  $this->rules->email_rules($user);
    }

    public function addPasswordRules(array &$rules): void
    {
        $rules[(UserFields::PASSWORD)->value] =  $this->rules->password_rules();
    }

    public function addPermissionsRules(Request $request, array &$rules): void
    {
        $permissionsKeyName = (UserFields::PERMISSIONS)->value;

        if ($request->has($permissionsKeyName)) {
            $rules[$permissionsKeyName] = $this->rules->permissions_rules();
            $rules["$permissionsKeyName.*"] = $this->rules->permission_item_rules();
        }
    }
}

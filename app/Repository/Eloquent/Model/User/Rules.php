<?php

namespace App\Repository\Eloquent\Model\User;

use App\Repository\Interfaces\Model\User\IRules;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class Rules implements IRules
{
    public function uniqueEmail(IUser $ignoreUser = null): Unique
    {
        $rule = Rule::unique(User::class, User::EMAIL);

        if ($ignoreUser instanceof IUser) {
            $rule->ignore($ignoreUser);
        }

        return $rule;
    }
}

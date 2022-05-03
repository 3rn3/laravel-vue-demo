<?php

namespace App\Http\Requests\User\Data\Helpers;

use App\Helpers\String\StringHelper;
use App\Http\Requests\User\Enum\UserFields;
use Illuminate\Http\Request;

class Email
{
    public function getEmail(Request $request): string
    {
        return StringHelper::safeString($request->input((UserFields::EMAIL)->value));
    }
}

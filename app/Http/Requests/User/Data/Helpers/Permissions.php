<?php

namespace App\Http\Requests\User\Data\Helpers;

use App\Http\Requests\User\Enum\UserFields;
use Illuminate\Http\Request;

class Permissions
{
    public function getPermissions(Request $request): array
    {
        return $request->input((UserFields::PERMISSIONS)->value, []);
    }
}

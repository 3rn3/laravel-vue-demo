<?php

namespace App\Http\Requests\Product\Data\Helpers;

use App\Helpers\String\StringHelper;
use App\Http\Requests\Product\Enum\ProductFields;
use Illuminate\Http\Request;

class Name
{
    public function getName(Request $request): string
    {
        return StringHelper::safeString($request->input((ProductFields::NAME)->value));
    }
}

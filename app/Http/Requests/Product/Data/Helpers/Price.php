<?php

namespace App\Http\Requests\Product\Data\Helpers;

use App\Http\Requests\Product\Enum\ProductFields;
use Illuminate\Http\Request;

class Price
{
    public function getPrice(Request $request): float
    {
        return $request->input((ProductFields::PRICE)->value);
    }
}

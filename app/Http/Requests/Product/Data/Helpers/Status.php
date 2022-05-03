<?php

namespace App\Http\Requests\Product\Data\Helpers;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Enum\Product\Status as ProductStatus;
use Illuminate\Http\Request;

class Status
{
    public function getStatus(Request $request): ProductStatus
    {
        return ProductStatus::from($request->input((ProductFields::STATUS)->value));
    }
}

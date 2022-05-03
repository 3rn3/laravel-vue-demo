<?php

namespace App\Http\Requests\Product\Validation;

use App\Repository\Enum\Product\Status;
use Illuminate\Validation\Rule;

class Rules
{
    public function name_rules(): array
    {
        return [
            'required',
            'string',
            'max:255',
        ];
    }

    public function status_rules(): array
    {
        return [
            'required',
            'integer',
            Rule::in(Status::toArray())
        ];
    }

    public function price_rules(): array
    {
        return [
            'required',
            'numeric',
        ];
    }
}

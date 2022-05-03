<?php

namespace App\Http\Requests;

class Rules
{
    public function integerRule(): array
    {
        return [
            'sometimes',
            'integer'
        ];
    }

    public function numericRule(): array
    {
        return [
            'sometimes',
            'numeric'
        ];
    }

    public function stringRule(): array
    {
        return [
            'sometimes',
            'string',
            'max:80'
        ];
    }

    public function emailRule(): array
    {
        return [
            'sometimes',
            'string',
            'email'
        ];
    }

    public function booleanRule(): array
    {
        return [
            'sometimes',
            'boolean'
        ];
    }
}

<?php

namespace App\Http\Requests\Product\Validation;

use App\Http\Requests\Product\Enum\ProductFields;

class Validate
{
    public function __construct(private readonly Rules $rules) {}

    public function productStoreValidate(): array
    {
        $rules = [];

        $this->addNameRules($rules);
        $this->addStatusRules($rules);
        $this->addPriceRules($rules);

        return $rules;
    }

    public function addNameRules(array &$rules): void
    {
        $rules[(ProductFields::NAME)->value] = $this->rules->name_rules();
    }

    public function addStatusRules(array &$rules): void
    {
        $rules[(ProductFields::STATUS)->value] = $this->rules->status_rules();
    }

    public function addPriceRules(array &$rules): void
    {
        $rules[(ProductFields::PRICE)->value] = $this->rules->price_rules();
    }
}

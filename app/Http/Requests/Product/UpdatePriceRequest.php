<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Product\Data\Helpers\Price;
use App\Http\Requests\Product\Validation\Validate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePriceRequest extends FormRequest
{
    public function __construct(protected Price $priceHelper, protected Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [];

        $this->validate->addPriceRules($rules);

        return $rules;
    }

    public function price(): float
    {
        return $this->priceHelper->getPrice($this);
    }
}

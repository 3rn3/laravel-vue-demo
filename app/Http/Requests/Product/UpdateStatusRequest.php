<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Product\Data\Helpers\Status;
use App\Http\Requests\Product\Validation\Validate;
use App\Repository\Enum\Product\Status as ProductStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function __construct(protected Status $statusHelper, protected Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
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

        $this->validate->addStatusRules($rules);

        return $rules;
    }

    public function status(): ProductStatus
    {
        return $this->statusHelper->getStatus($this);
    }
}

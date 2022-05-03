<?php

namespace App\Http\Requests\Product;

use App\Helpers\String\StringHelper;
use App\Http\Requests\Rules;
use App\Repository\Enum\Product\SearchFields;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    protected array $searchFields = [];

    public function __construct(protected Rules $rules, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        return [
            (SearchFields::ID)->value => $this->rules->integerRule(),
            (SearchFields::NAME)->value => $this->rules->stringRule(),
            (SearchFields::STATUS)->value => $this->rules->integerRule(),
            (SearchFields::PRICE)->value => $this->rules->numericRule(),
        ];
    }

    public function getSearchFields(): array
    {
        if (count($this->searchFields) === 0)
        {
            $parameters = $this->only(SearchFields::toArray());

            StringHelper::cleanStringIntoAnArray($parameters);

            $this->searchFields = $parameters;
        }

        return $this->searchFields;
    }
}

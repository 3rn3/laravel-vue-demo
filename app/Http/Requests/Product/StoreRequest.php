<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Product\Data\Helpers\Name;
use App\Http\Requests\Product\Data\Helpers\Price;
use App\Http\Requests\Product\Data\Helpers\Status as StatusHelper;
use App\Http\Requests\Product\Data\ProductStoreDTO;
use App\Http\Requests\Product\Validation\Validate;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function __construct(protected Name $nameHelper, protected StatusHelper $statusHelper, protected Price $priceHelper, protected Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
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
        return $this->validate->productStoreValidate();
    }

    public function productStoreDTO(): IProductStoreDTO
    {
        return new ProductStoreDTO($this, $this->nameHelper, $this->statusHelper, $this->priceHelper);
    }
}

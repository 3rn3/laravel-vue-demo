<?php

namespace App\Http\Resources\Product;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Interfaces\Model\Product\IProduct;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @see IProduct
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            (ProductFields::ID)->value => $this->getId(),
            (ProductFields::NAME)->value => $this->getName(),
            (ProductFields::STATUS)->value => $this->getStatus()->value,
            (ProductFields::STATUS_NAME)->value => $this->getStatus()->toString(),
            (ProductFields::PRICE)->value => $this->getPrice(),
        ];
    }
}

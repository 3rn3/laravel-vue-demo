<?php

namespace App\Repository\Eloquent\Model\Product;

use App\Repository\Enum\Product\Status;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;

class ProductStoreFields
{
    public function toArray(IProductStoreDTO $productStoreDTO): array
    {
        $fields = [];

        $this->addName($productStoreDTO->name(), $fields);
        $this->addStatus($productStoreDTO->status(), $fields);
        $this->addPrice($productStoreDTO->price(), $fields);

        return $fields;
    }

    public function addName(string $name, array &$fields): void
    {
        $fields[Product::NAME] = $name;
    }

    public function addStatus(Status $status, array &$fields): void
    {
        $fields[Product::STATUS] = $status->value;
    }

    public function addPrice(float $price, array &$fields): void
    {
        $fields[Product::PRICE] = $price;
    }
}

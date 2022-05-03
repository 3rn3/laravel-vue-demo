<?php

namespace App\Repository\Eloquent\Model\Product;

use App\Repository\Eloquent\Model\Product\Pipeline\Search\ProductSearch;
use App\Repository\Enum\Product\SearchFields;
use App\Repository\Enum\Product\Status;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductRepository;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductRepository implements IProductRepository
{
    public function __construct(private ProductStoreFields $productStoreFields, private ProductSearch $productSearch) {}

    public function store(IProductStoreDTO $productStoreDTO): IProduct
    {
        return Product::create($this->productStoreFields->toArray($productStoreDTO));
    }

    public function updateStatus(IProduct $product, Status $status): void
    {
        $fields = [];

        $this->productStoreFields->addStatus($status, $fields);

        $this->update($product, $fields);
    }

    public function updatePrice(IProduct $product, float $price): void
    {
        $fields = [];

        $this->productStoreFields->addPrice($price, $fields);

        $this->update($product, $fields);
    }

    public function find(array $searchFields): IProduct
    {
        if (Arr::has($searchFields, (SearchFields::ID)->value)) {
            return $this->productSearch->find($this->builder(), $searchFields);
        }

        throw new ObjectNotFoundException("Invalid Search Fields");
    }

    public function search(array $searchFields): Paginator|Collection
    {
        return $this->productSearch->search($this->builder(), $searchFields);
    }


    public function update(Product $product, array $fields): bool
    {
        $updated = $product->update($fields);

        $product->refresh();

        return $updated;
    }

    protected function builder(): Builder
    {
        return Product::query();
    }

}

<?php

namespace App\Services\Product\Implementation\Services;

use App\Repository\Enum\Product\Status;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProductServicesFacade implements IProductServicesFacade
{
    public function __construct(protected SubServices $subServices) {}

    public function storeProduct(IProductStoreDTO $productStoreDTO): IProduct
    {
        return $this->subServices->productServices()->store()->store($productStoreDTO);
    }

    public function updateProductStatus(IProduct $product, Status $status): void
    {
        $this->subServices->productServices()->update()->updateStatus($product, $status);
    }

    public function updateProductPrice(IProduct $product, float $price): void
    {
        $this->subServices->productServices()->update()->updatePrice($product, $price);
    }

    public function findProduct(array $searchFields): IProduct
    {
        return $this->subServices->productServices()->search()->find($searchFields);
    }

    public function searchProduct(array $searchFields): Paginator|Collection
    {
        return $this->subServices->productServices()->search()->search($searchFields);
    }

}

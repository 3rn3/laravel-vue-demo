<?php

namespace App\Services\Product\Interfaces;

use App\Repository\Enum\Product\Status;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface IProductServicesFacade
{
    public function storeProduct(IProductStoreDTO $productStoreDTO): IProduct;

    public function updateProductStatus(IProduct $product, Status $status): void;

    public function updateProductPrice(IProduct $product, float $price): void;

    /**
     * @param array $searchFields
     * @return IProduct
     * @throws ObjectNotFoundException
     */
    public function findProduct(array $searchFields): IProduct;

    /**
     * @param array $searchFields
     * @return Paginator<IProduct> | Collection<IProduct>
     */
    public function searchProduct(array $searchFields): Paginator | Collection;
}

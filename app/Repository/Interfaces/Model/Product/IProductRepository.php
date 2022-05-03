<?php

namespace App\Repository\Interfaces\Model\Product;

use App\Repository\Enum\Product\Status;
use App\Repository\Exceptions\ObjectNotFoundException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

interface IProductRepository
{
    public function store(IProductStoreDTO $productStoreDTO): IProduct;

    public function updateStatus(IProduct $product, Status $status): void;

    public function updatePrice(IProduct $product, float $price): void;

    /**
     * @param array $searchFields
     * @return IProduct
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IProduct;

    /**
     * @param array $searchFields
     * @return Paginator<IProduct> | Collection<IProduct>
     */
    public function search(array $searchFields): Paginator | Collection;
}

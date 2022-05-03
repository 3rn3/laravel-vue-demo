<?php

namespace App\Services\Product\Implementation\Services\Product;

use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

class Search
{
    public function __construct(protected IProductRepository $productRepository) {}

    /**
     * @param array $searchFields
     * @return IProduct
     * @throws ObjectNotFoundException
     */
    public function find(array $searchFields): IProduct
    {
        return $this->productRepository->find($searchFields);
    }

    /**
     * @param array $searchFields
     * @return Paginator<IProduct> | Collection<IProduct>
     */
    public function search(array $searchFields): Paginator | Collection
    {
        return $this->productRepository->search($searchFields);
    }
}

<?php

namespace App\Services\Product\Implementation\Services\Product;

use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductRepository;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;

class Store
{
    public function __construct(protected IProductRepository $productRepository) {}

    public function store(IProductStoreDTO $productStoreDTO): IProduct
    {
        return $this->productRepository->store($productStoreDTO);
    }
}

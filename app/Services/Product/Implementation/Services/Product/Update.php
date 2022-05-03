<?php

namespace App\Services\Product\Implementation\Services\Product;

use App\Repository\Enum\Product\Status;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductRepository;

class Update
{
    public function __construct(protected IProductRepository $productRepository) {}

    public function updateStatus(IProduct $product, Status $status): void
    {
        $this->productRepository->updateStatus($product, $status);
    }

    public function updatePrice(IProduct $product, float $price): void
    {
        $this->productRepository->updatePrice($product, $price);
    }
}

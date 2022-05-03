<?php

namespace App\Services\Product\Implementation\Services;

use App\Services\Product\Implementation\Services\Product\Services as ProductServices;

class SubServices
{
    protected ?ProductServices $productServices = null;

    public function productServices(): ProductServices
    {
        if (! $this->productServices instanceof ProductServices) {
            $this->productServices = resolve(ProductServices::class);
        }

        return $this->productServices;
    }


}

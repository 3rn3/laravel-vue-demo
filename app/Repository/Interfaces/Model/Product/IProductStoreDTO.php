<?php

namespace App\Repository\Interfaces\Model\Product;

use App\Repository\Enum\Product\Status;

interface IProductStoreDTO
{
    public function name(): string;

    public function status(): Status;

    public function price(): float;
}

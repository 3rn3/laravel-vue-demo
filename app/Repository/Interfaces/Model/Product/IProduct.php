<?php

namespace App\Repository\Interfaces\Model\Product;

use App\Repository\Enum\Product\Status;

interface IProduct
{
    public function getId(): int;

    public function getName(): string;

    public function getStatus(): Status;

    public function getPrice(): float;
}

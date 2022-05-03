<?php

namespace App\Http\Requests\Product\Data;

use App\Http\Requests\Product\Data\Helpers\Name;
use App\Http\Requests\Product\Data\Helpers\Price;
use App\Http\Requests\Product\Data\Helpers\Status as StatusHelper;
use App\Repository\Enum\Product\Status;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use Illuminate\Http\Request;

class ProductStoreDTO implements IProductStoreDTO
{
    public function __construct(protected Request $request, protected Name $nameHelper, protected StatusHelper $statusHelper, protected Price $priceHelper) {}

    public function name(): string
    {
        return $this->nameHelper->getName($this->request);
    }

    public function status(): Status
    {
        return $this->statusHelper->getStatus($this->request);
    }

    public function price(): float
    {
        return $this->priceHelper->getPrice($this->request);
    }

}

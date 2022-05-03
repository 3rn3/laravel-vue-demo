<?php

namespace App\Repository\Eloquent\Model\Product\Helper;

use App\Repository\Eloquent\Model\Product\Product;

class AddTableToProductField
{
    public static function addTableToProductField(string $field): string
    {
        return Product::TABLE_NAME.".$field";
    }
}

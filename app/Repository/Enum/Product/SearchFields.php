<?php

namespace App\Repository\Enum\Product;

enum SearchFields : string
{
    case ID = 'id';
    case NAME = 'name';
    case STATUS = 'status';
    case PRICE = 'price';

    public static function toArray(): array
    {
        return [
            'id',
            'name',
            'status',
            'price'
        ];
    }
}

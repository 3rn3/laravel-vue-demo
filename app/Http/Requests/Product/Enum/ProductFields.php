<?php

namespace App\Http\Requests\Product\Enum;

enum ProductFields : string
{
    case ID = 'id';
    case NAME = 'name';
    case STATUS = 'status';
    case PRICE = 'price';
    case STATUS_NAME = 'status_name';
}

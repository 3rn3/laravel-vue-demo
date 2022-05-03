<?php

namespace App\Gates\Product;

enum GateNames : string
{
    case STORE = 'product.store';
    case READ = 'product.read';
}

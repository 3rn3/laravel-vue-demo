<?php

namespace App\Repository\Eloquent\Model\Product;

use App\Repository\Interfaces\Model\Product\IProductRepository;
use Illuminate\Foundation\Application;

class Register
{
    public static function register(Application $application): void
    {
        $application->bind(IProductRepository::class, ProductRepository::class);;
    }
}

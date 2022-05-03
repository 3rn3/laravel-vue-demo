<?php

namespace App\Http\Controllers\Product\Search;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchUIController extends Controller
{
    public function __construct(protected IProductServicesFacade $productServicesFacade) {}

    public function products(): Response
    {
        return Inertia::render('Product/Products', [
            'products' => ProductResource::collection($this->productServicesFacade->searchProduct([]))
        ]);
    }
}

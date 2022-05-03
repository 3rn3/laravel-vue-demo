<?php

namespace App\Http\Controllers\Product\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Resources\Product\ProductResource;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class StoreController extends Controller
{
    public function __construct(protected IProductServicesFacade $productServicesFacade) {}

    public function store(StoreRequest $storeRequest): JsonResponse
    {
        try {
            return (new ProductResource($this->productServicesFacade->storeProduct($storeRequest->productStoreDTO())))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

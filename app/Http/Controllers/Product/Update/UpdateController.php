<?php

namespace App\Http\Controllers\Product\Update;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdatePriceRequest;
use App\Http\Requests\Product\UpdateStatusRequest;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class UpdateController extends Controller
{
    public function __construct(protected IProductServicesFacade $productServicesFacade) {}

    public function updatePrice(IProduct $product, UpdatePriceRequest $updatePriceRequest): JsonResponse
    {
        return $this->makeUpdate(function () use($product, $updatePriceRequest) {
            $this->productServicesFacade->updateProductPrice($product, $updatePriceRequest->price());
        });
    }

    public function updateStatus(IProduct $product, UpdateStatusRequest $updateStatusRequest): JsonResponse
    {
        return $this->makeUpdate(function () use ($product, $updateStatusRequest) {
            $this->productServicesFacade->updateProductStatus($product, $updateStatusRequest->status());
        });
    }

    protected function makeUpdate(Closure $updateClosure): JsonResponse
    {
        try {
            $updateClosure();
            return new JsonResponse('', Response::HTTP_NO_CONTENT);
        }catch (Throwable $exception) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

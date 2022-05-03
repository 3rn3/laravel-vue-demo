<?php

namespace App\Http\Controllers\Product\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SearchRequest;
use App\Http\Resources\Product\ProductResource;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Throwable;

class SearchController extends Controller
{
    public function __construct(protected IProductServicesFacade $productServicesFacade) {}

    public function search(SearchRequest $searchRequest): JsonResponse|AnonymousResourceCollection
    {
        try {
            return ProductResource::collection(
                $this->productServicesFacade->searchProduct($searchRequest->getSearchFields())
            );
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }

    public function view(IProduct $product): JsonResponse|ProductResource
    {
        try {
            return new ProductResource($product);
        }catch (Throwable $exception)
        {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;

            return new JsonResponse(Response::$statusTexts[$status], $status);
        }
    }
}

<?php

namespace App\Repository\Eloquent\Model\Product\Pipeline\Search;

use App\Repository\Eloquent\Model\Product\Pipeline\Search\Pipes\Id;
use App\Repository\Eloquent\Model\Product\Pipeline\Search\Pipes\Name;
use App\Repository\Eloquent\Model\Product\Pipeline\Search\Pipes\Price;
use App\Repository\Eloquent\Model\Product\Pipeline\Search\Pipes\Status;
use App\Repository\Eloquent\Model\Product\Product;
use App\Repository\Eloquent\Pipeline\Search\Search;
use App\Repository\Exceptions\ObjectNotFoundException;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProductSearch extends Search
{
    public function find(Builder $builder, array $searchFields): Product
    {
        $builder->select($this->selectFields());

        $this->builderSetup($this->createPassable($builder, $searchFields));

        $product = $builder->first();

        return $product instanceof Product
            ? $product
            : throw new ObjectNotFoundException("Product Not Found");
    }

    protected function selectFields(): string
    {
        return Product::TABLE_NAME.'.*';
    }

    protected function pipes(): array
    {
        return [
            Id::class,
            Name::class,
            Price::class,
            Status::class,
        ];
    }

}

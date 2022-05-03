<?php

namespace Database\Seeders;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Enum\Product\Status;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use App\Services\Product\Interfaces\IProductServicesFacade;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function __construct(protected IProductServicesFacade $productServicesFacade, protected ProductFactory $productFactory) {}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $times = rand(1, 80);

        for ($i = 0; $i < $times; $i++) {
            $this->storeProduct();;
        }
    }

    protected function storeProduct(): void
    {
        $this->productServicesFacade->storeProduct($this->productStoreDTO());
    }

    protected function productStoreDTO(): IProductStoreDTO
    {
        $fields = $this->productFactory->definition();

        return new class($fields) implements IProductStoreDTO {
            public function __construct(protected array $fields) {}

            public function name(): string
            {
                return $this->fields[(ProductFields::NAME)->value];
            }

            public function status(): Status
            {
                return Status::from($this->fields[(ProductFields::STATUS)->value]);
            }

            public function price(): float
            {
                return $this->fields[(ProductFields::PRICE)->value];
            }
        };
    }
}

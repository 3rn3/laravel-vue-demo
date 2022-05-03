<?php

namespace Database\Factories;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Interfaces\Model\Product\IProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<IProduct>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            (ProductFields::NAME)->value => $this->faker->name,
            (ProductFields::STATUS)->value => rand(1, 3),
            (ProductFields::PRICE)->value => $this->faker->randomDigit(),
        ];
    }
}

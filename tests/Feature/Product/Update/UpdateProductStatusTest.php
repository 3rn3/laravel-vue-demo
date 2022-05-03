<?php

namespace Tests\Feature\Product\Update;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Enum\Product\Status;
use App\Repository\Enum\User\SearchFields;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use App\Services\Product\Interfaces\IProductServicesFacade;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class UpdateProductStatusTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updateUrl = "/product/update/status/";



    public function test_update_product_status_successfully()
    {
        $this->actingAsAuthorizedUser();

        $product = $this->createProduct();

        $response = $this->put($this->updateUrl.$product->getId(), [
            (ProductFields::STATUS)->value => (Status::Hold)->value
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_update_product_status_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $product = $this->createProduct();

        $response = $this->post($this->updateUrl.$product->getId(), [
            (ProductFields::STATUS)->value => (Status::Hold)->value
        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_update_product_status_required_fields()
    {
        $this->actingAsAuthorizedUser();

        $product = $this->createProduct();

        $response = $this->put($this->updateUrl.$product->getId(), [
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (ProductFields::STATUS)->value => 'The status field is required.',
        ]);
    }

    public function test_update_product_status_invalid_fields()
    {
        $this->actingAsAuthorizedUser();

        $product = $this->createProduct();

        $response = $this->put($this->updateUrl.$product->getId(), [
            (ProductFields::STATUS)->value => "asd"
        ]);

        $response->assertSessionHasErrors([
            (ProductFields::STATUS)->value => "The status must be an integer.",
            (ProductFields::STATUS)->value => "The selected status is invalid.",
        ]);
    }

    public function test_update_product_price_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $product = $this->createProduct();

        $response = $this->put($this->updateUrl.$product->getId(), [
            (ProductFields::PRICE)->value => 80
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }



    protected function actingAsAuthorizedUser(): void
    {
        $user = $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'root@demo.com']);

        $this->actingAs($user);
    }

    protected function actingAsUnAuthorizedUser(): void
    {
        $user = $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'readOnly@demo.com']);

        $this->actingAs($user);
    }

    protected function userServicesFacade(): IUserServicesFacade
    {
        return resolve(IUserServicesFacade::class);
    }

    protected function productServicesFacade(): IProductServicesFacade
    {
        return resolve(IProductServicesFacade::class);
    }

    protected function createProduct(): IProduct
    {
        return $this->productServicesFacade()->storeProduct(
            new class () implements IProductStoreDTO {
                public function name(): string
                {
                    return "successProduct";
                }

                public function status(): Status
                {
                    return  Status::Active;
                }

                public function price(): float
                {
                    return 45;
                }

            }
        );
    }
}

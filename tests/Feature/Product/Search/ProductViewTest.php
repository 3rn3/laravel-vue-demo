<?php

namespace Tests\Feature\Product\Search;

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

class ProductViewTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updateUrl = "/product/view/";

    public function test_product_view_successfully()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updateUrl.$this->createProduct()->getId());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_product_view_does_not_found()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updateUrl."454");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_product_view_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->updateUrl.$this->createProduct()->getId());

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_product_view_unauthorized()
    {
        $response = $this->get($this->updateUrl.$this->createProduct()->getId());

        $response->assertStatus(Response::HTTP_FOUND);
    }

    protected function actingAsAuthorizedUser(): void
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

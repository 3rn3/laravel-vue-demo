<?php

namespace Tests\Feature\Product\Search;

use App\Repository\Enum\Product\SearchFields;
use App\Repository\Enum\Product\Status;
use App\Repository\Enum\User\SearchFields as UserSearchFields;
use App\Repository\Interfaces\Model\Product\IProduct;
use App\Repository\Interfaces\Model\Product\IProductStoreDTO;
use App\Services\Product\Interfaces\IProductServicesFacade;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $searchUrl = "product/search";

    public function test_product_search_successfully()
    {
        $this->actingAsAuthorizedUser();

        $this->createProduct();

        $response = $this->get($this->searchUrl);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'name' => 'successProduct',
            'status' => 1,
            'price' => 45
        ]);
    }

    public function test_product_search_successProduct_name_successfully()
    {
        $this->actingAsAuthorizedUser();

        $this->createProduct();

        $response = $this->get($this->searchUrl, [
            (SearchFields::NAME)->value => "successProduct"
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'name' => 'successProduct',
            'status' => 1,
            'price' => 45
        ]);
    }

    public function test_product_search_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->searchUrl);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_product_search_unauthorized()
    {
        $response = $this->get($this->searchUrl);

        $response->assertStatus(Response::HTTP_FOUND);
    }


    protected function actingAsAuthorizedUser(): void
    {
        $user = $this->userServicesFacade()->findUser([(UserSearchFields::EMAIL)->value => 'readOnly@demo.com']);

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

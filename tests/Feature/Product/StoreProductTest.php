<?php

namespace Tests\Feature\Product;

use App\Http\Requests\Product\Enum\ProductFields;
use App\Repository\Enum\Product\Status;
use App\Repository\Enum\User\SearchFields;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $storeUrl = "/product/store";


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_store_successfully()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (ProductFields::NAME)->value => 'successProduct',
            (ProductFields::STATUS)->value => (Status::Active)->value,
            (ProductFields::PRICE)->value => 45,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_product_store_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->storeUrl, [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_product_store_required_fields()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (ProductFields::NAME)->value => 'The name field is required.',
            (ProductFields::STATUS)->value => 'The status field is required.',
            (ProductFields::PRICE)->value => 'The price field is required.',
        ]);
    }

    public function test_product_store_invalid_fields()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (ProductFields::NAME)->value => 123,
            (ProductFields::STATUS)->value => 12321312,
            (ProductFields::PRICE)->value => "asd",
        ]);

        $response->assertSessionHasErrors([
            (ProductFields::NAME)->value => 'The name must be a string.',
            (ProductFields::STATUS)->value => 'The selected status is invalid.',
            (ProductFields::PRICE)->value => 'The price must be a number.',
        ]);
    }

    public function test_product_store_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->post($this->storeUrl, [

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
}

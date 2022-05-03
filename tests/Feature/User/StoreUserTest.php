<?php

namespace Tests\Feature\User;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Enum\User\SearchFields;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $storeUrl = "/user/store";

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_stored_successfully()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (UserFields::NAME)->value => 'successName',
            (UserFields::EMAIL)->value => 'successEmail@demo.com',
            (UserFields::PASSWORD)->value => 'ASD147852!',
            'password_confirmation' => 'ASD147852!',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_user_stored_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->storeUrl, [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_user_store_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (UserFields::NAME)->value => 'successName',
            (UserFields::EMAIL)->value => 'successEmail@demo.com',
            (UserFields::PASSWORD)->value => 'ASD147852!',
            'password_confirmation' => 'ASD147852!',
            (UserFields::PERMISSIONS)->name => [1,2]
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_user_store_invalid_fields()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (UserFields::NAME)->value => 456465,
            (UserFields::EMAIL)->value => 'readOnly@demo.com',
            (UserFields::ACTIVE)->value => 'readOnly@demo.com',
            (UserFields::PASSWORD)->value => 'ASD147852',
            'password_confirmation' => 'ASD147852!',
            (UserFields::PERMISSIONS)->value => 'sjkdhskdf'
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::NAME)->value => "The name must be a string.",
            (UserFields::EMAIL)->value => "The email has already been taken.",
            (UserFields::PASSWORD)->value => "The password confirmation does not match.",
            (UserFields::PERMISSIONS)->value => "The permissions must be an array.",
        ]);
    }

    public function test_user_store_invalid_permissions()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->post($this->storeUrl, [
            (UserFields::NAME)->value => 456465,
            (UserFields::EMAIL)->value => 'readOnly@demo.com',
            (UserFields::ACTIVE)->value => 'readOnly@demo.com',
            (UserFields::PASSWORD)->value => 'ASD147852',
            'password_confirmation' => 'ASD147852!',
            (UserFields::PERMISSIONS)->value => [
                "asdasd",
                '76543',
                1
            ],
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PERMISSIONS)->value.".0" => "The permissions.0 must be an integer.",
            (UserFields::PERMISSIONS)->value.".1" => "The selected permissions.1 is invalid.",
        ]);
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

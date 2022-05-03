<?php

namespace Tests\Feature\User\Update;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Enum\User\SearchFields;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class UpdateUserPermissionsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updatePermissionsUrl = "user/update/permission/";

    public function test_update_user_permissions_successfully()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updatePermissionsUrl.$this->user()->getId(), [
            (UserFields::PERMISSIONS)->value => [
                1,
                2,
                3
            ],
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_update_user_permissions_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updatePermissionsUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_update_user_permissions_permissions_field_is_invalid()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updatePermissionsUrl.$this->user()->getId(), [
            (UserFields::PERMISSIONS)->value => 'root@demo.com'
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PERMISSIONS)->value => "The permissions must be an array.",
        ]);
    }

    public function test_update_user_permissions_field_is_required()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->put($this->updatePermissionsUrl.$this->user()->getId(), [
            (UserFields::PERMISSIONS)->value => [],
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PERMISSIONS)->value => "The permissions field is required.",
        ]);
    }

    public function test_update_user_permissions_invalid_permissions_item_fields()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->put($this->updatePermissionsUrl.$this->user()->getId(), [
            (UserFields::PERMISSIONS)->value => [
                "asdasd",
                4654644,
                1
            ],
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PERMISSIONS)->value.".0" => "The permissions.0 must be an integer.",
            (UserFields::PERMISSIONS)->value.".1" => "The selected permissions.1 is invalid.",
        ]);
    }

    public function test_update_user_permissions_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->put($this->updatePermissionsUrl.$this->rootUser()->getId(), [
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }


    protected function actingAsAuthorizedUser(): void
    {
        $this->actingAs($this->rootUser());
    }

    protected function actingAsUnAuthorizedUser(): void
    {
        $this->actingAs($this->user());
    }

    protected function rootUser(): IUser
    {
        return $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'root@demo.com']);;
    }

    protected function user(): IUser
    {
        return $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'readOnly@demo.com']);
    }

    protected function userServicesFacade(): IUserServicesFacade
    {
        return resolve(IUserServicesFacade::class);
    }
}

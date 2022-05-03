<?php

namespace Feature\User\Update;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Enum\User\SearchFields;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class UpdateUserNameTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updateNameUrl = "/user/update/name/";



    public function test_update_name_successfully()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updateNameUrl.$this->user()->getId(), [
            (UserFields::NAME)->value => 'successfully'
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_update_name_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updateNameUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_update_name_field_is_required()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->put($this->updateNameUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::NAME)->value => "The name field is required.",
        ]);
    }

    public function test_update_name_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->put($this->updateNameUrl.$this->user()->getId(), [
            $fields[(UserFields::NAME)->value] = 89798
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    protected function actingAsAuthorizedUser(): void
    {
        $user = $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'root@demo.com']);

        $this->actingAs($user);
    }

    protected function actingAsUnAuthorizedUser(): void
    {
        $this->actingAs($this->user());
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

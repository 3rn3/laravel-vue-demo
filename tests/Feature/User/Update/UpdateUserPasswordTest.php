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

class UpdateUserPasswordTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updatePasswordUrl = "/user/update/password/";

    public function test_update_password_successfully()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updatePasswordUrl.$this->user()->getId(), [
            (UserFields::PASSWORD)->value => 'ASD147852!',
            'password_confirmation' => 'ASD147852!',
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_update_password_password_confirmation_does_not_match()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updatePasswordUrl.$this->user()->getId(), [
            (UserFields::PASSWORD)->value => 'ASD147852!',
            'password_confirmation' => 'ASD1478',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PASSWORD)->value => "The password confirmation does not match.",
        ]);
    }

    public function test_update_password_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updatePasswordUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_update_password_field_is_required()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->put($this->updatePasswordUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::PASSWORD)->value => "The password field is required.",
        ]);
    }

    public function test_update_email_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->put($this->updatePasswordUrl.$this->user()->getId(), [
            $fields[(UserFields::PASSWORD)->value] = "asdfsdfdsf"
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

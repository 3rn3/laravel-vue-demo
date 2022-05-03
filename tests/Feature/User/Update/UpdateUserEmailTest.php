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

class UpdateUserEmailTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $updateEmailUrl = "/user/update/email/";

    public function test_update_email_successfully()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updateEmailUrl.$this->user()->getId(), [
            (UserFields::EMAIL)->value => 'successfully@mail.com'
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_update_email_invalid_method()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->get($this->updateEmailUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_update_email_has_already_been_taken()
    {
        $this->actingAsAuthorizedUser();
        $response = $this->put($this->updateEmailUrl.$this->user()->getId(), [
            (UserFields::EMAIL)->value => 'root@demo.com'
        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::EMAIL)->value => "The email has already been taken.",
        ]);
    }

    public function test_update_email_field_is_required()
    {
        $this->actingAsAuthorizedUser();

        $response = $this->put($this->updateEmailUrl.$this->user()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_FOUND);

        $response->assertSessionHasErrors([
            (UserFields::EMAIL)->value => "The email field is required.",
        ]);
    }

    public function test_update_email_unauthorized()
    {
        $this->actingAsUnAuthorizedUser();

        $response = $this->put($this->updateEmailUrl.$this->user()->getId(), [
            $fields[(UserFields::EMAIL)->value] = "asd@mai.com"
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

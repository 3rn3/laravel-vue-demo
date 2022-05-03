<?php

namespace Tests\Feature\User\Search;

use App\Repository\Enum\User\SearchFields;
use App\Repository\Interfaces\Model\User\IUser;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\CreatesApplication;
use Tests\TestCase;

class UserViewTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $viewUrl = "user/view/";

    public function test_user_view_successfully()
    {
        $this->actingAs($this->userRoot());

        $response = $this->get($this->viewUrl.$this->userReadOnly()->getId());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_user_view_does_not_found()
    {
        $this->actingAs($this->userRoot());

        $response = $this->get($this->viewUrl."4656");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_user_view_invalid_method()
    {
        $this->actingAs($this->userRoot());

        $response = $this->post($this->viewUrl.$this->userRoot()->getId(), [

        ]);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_user_view_unauthorized()
    {
        $response = $this->get($this->viewUrl.$this->userReadOnly()->getId());

        $response->assertStatus(Response::HTTP_FOUND);
    }

    protected function userRoot(): IUser
    {
        return $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'root@demo.com']);
    }

    protected function userReadOnly(): IUser
    {
        return $this->userServicesFacade()->findUser([(SearchFields::EMAIL)->value => 'readOnly@demo.com']);
    }

    protected function userServicesFacade(): IUserServicesFacade
    {
        return resolve(IUserServicesFacade::class);
    }
}

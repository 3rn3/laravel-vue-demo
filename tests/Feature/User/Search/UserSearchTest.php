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

class UserSearchTest extends TestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    protected bool $seed = true;
    protected string $searchUrl = "user/search";

    public function test_user_search_successfully()
    {
        $this->actingAs($this->userReadOnly());

        $response = $this->get($this->searchUrl);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'name' => 'root',
            'email' => 'root@demo.com'
        ]);

        $response->assertJsonFragment([
            'name' => 'readOnly',
            'email' => 'readOnly@demo.com'
        ]);
    }

    public function test_user_search_root_user_successfully()
    {
        $this->actingAs($this->userReadOnly());

        $response = $this->get($this->searchUrl, [
            (SearchFields::EMAIL)->value => 'root@demo.com'
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonFragment([
            'name' => 'root',
            'email' => 'root@demo.com'
        ]);
    }

    public function test_user_search_invalid_method()
    {
        $this->actingAs($this->userRoot());

        $response = $this->post($this->searchUrl);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function test_user_search_unauthorized()
    {
        $response = $this->get($this->searchUrl);

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

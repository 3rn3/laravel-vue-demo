<?php

namespace Database\Seeders;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Enum\Permission\PermissionName;
use App\Repository\Enum\Permission\SearchFields;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use App\Services\User\Interfaces\IUserServicesFacade;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function __construct(protected IUserServicesFacade $userServicesFacade, protected UserFactory $userFactory){}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRootUser();
        $this->createReadOnlyUser();
        $this->createRandomUsers();
    }

    protected function createRootUser(): void
    {
        $permissions = [];
        $this->addPermissionUserWrite($permissions);
        $this->addPermissionUserRead($permissions);
        $this->addPermissionProductWrite($permissions);
        $this->addPermissionProductRead($permissions);

        $this->userServicesFacade->storeUser($this->userStoreDTO($this->rootUserFields()), ...$permissions);
    }

    protected function rootUserFields(): array
    {
        $fields = $this->userFactory->definition();

        $fields[(UserFields::NAME)->value] = 'root';
        $fields[(UserFields::EMAIL)->value] = 'root@demo.com';
        $fields[(UserFields::PASSWORD)->value] = 'DemoApp@1';

        return $fields;
    }

    protected function createReadOnlyUser(): void
    {
        $permissions = [];
        $this->addPermissionUserRead($permissions);
        $this->addPermissionProductRead($permissions);

        $this->userServicesFacade->storeUser($this->userStoreDTO($this->readOnlyUserFields()), ...$permissions);
    }

    protected function readOnlyUserFields(): array
    {
        $fields = $this->userFactory->definition();

        $fields[(UserFields::NAME)->value] = 'readOnly';
        $fields[(UserFields::EMAIL)->value] = 'readOnly@demo.com';
        $fields[(UserFields::PASSWORD)->value] = 'DemoApp@1';

        return $fields;
    }

    protected function createRandomUsers(): void
    {
        $times = rand(1, 80);

        for ($i = 0; $i < $times; $i++) {
            $this->userServicesFacade->storeUser($this->userStoreDTO($this->userFactory->definition()), ...$this->randomPermissions());
        }

    }

    protected function randomPermissions(): array
    {
        $permissions = [];

        $permissionsClosure = [];

        $permissionsClosure[] = function () use(&$permissions) {
            $this->addPermissionUserWrite($permissions);
        };

        $permissionsClosure[] = function () use(&$permissions) {
            $this->addPermissionUserRead($permissions);
        };

        $permissionsClosure[] = function () use(&$permissions) {
            $this->addPermissionProductWrite($permissions);
        };

        $permissionsClosure[] = function () use(&$permissions) {
            $this->addPermissionProductRead($permissions);
        };


        $times = rand(1, count($permissionsClosure));

        for ($i = 0; $i < $times; $i++) {
            $closureLength = count($permissionsClosure);

            if ($closureLength > 1)
            {
                $selectClosure = rand(0, $closureLength-1);
            }else {
                $selectClosure = 0;
            }

            $permissionsClosure[$selectClosure]();
            unset($permissionsClosure[$selectClosure]);
            $permissionsClosure = array_values($permissionsClosure);
        }

        return $permissions;
    }

    protected function userStoreDTO(array $fields): IUserStoreDTO
    {
        return new class ($fields) implements IUserStoreDTO {
            public function __construct(protected array $fields) {}

            public function name(): string
            {
                return $this->fields[(UserFields::NAME)->value];
            }

            public function email(): string
            {
                return $this->fields[(UserFields::EMAIL)->value];
            }

            public function password(): string
            {
                return $this->fields[(UserFields::PASSWORD)->value];
            }

            public function isActive(): bool
            {
                return true;
            }
        };
    }

    protected function addPermissionUserRead(array &$permissions): void
    {
        $permissions[] = $this->userServicesFacade->findPermission([
            (SearchFields::NAME)->value => (PermissionName::USER_READ)->value
        ])->getId();
    }

    protected function addPermissionUserWrite(array &$permissions): void
    {
        $permissions[] = $this->userServicesFacade->findPermission([
            (SearchFields::NAME)->value => (PermissionName::USER_WRITE)->value
        ])->getId();
    }

    protected function addPermissionProductWrite(array &$permissions): void
    {
        $permissions[] = $this->userServicesFacade->findPermission([
            (SearchFields::NAME)->value => (PermissionName::PRODUCT_WRITE)->value
        ])->getId();
    }

    protected function addPermissionProductRead(array &$permissions): void
    {
        $permissions[] = $this->userServicesFacade->findPermission([
            (SearchFields::NAME)->value => (PermissionName::PRODUCT_READ)->value
        ])->getId();
    }

}

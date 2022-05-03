<?php

namespace Database\Seeders;

use App\Repository\Enum\Permission\PermissionName;
use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;
use App\Services\User\Interfaces\IUserServicesFacade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function __construct(protected IUserServicesFacade $userServicesFacade) {}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->userPermissions();
        $this->productPermissions();
    }

    protected function userPermissions(): void
    {
        $this->userServicesFacade->storePermission($this->permissionStoreDTO([
            'name' => (PermissionName::USER_WRITE)->value,
            'display_name' => "User Write"
        ]));

        $this->userServicesFacade->storePermission($this->permissionStoreDTO([
            'name' => (PermissionName::USER_READ)->value,
            'display_name' => "User Read"
        ]));
    }

    protected function productPermissions(): void
    {
        $this->userServicesFacade->storePermission($this->permissionStoreDTO([
            'name' => (PermissionName::PRODUCT_WRITE)->value,
            'display_name' => "Product Write"
        ]));

        $this->userServicesFacade->storePermission($this->permissionStoreDTO([
            'name' => (PermissionName::PRODUCT_READ)->value,
            'display_name' => "Product Read"
        ]));
    }


    protected function permissionStoreDTO(array $fields): IPermissionStoreDTO
    {
        return new class($fields) implements IPermissionStoreDTO {
            public function __construct(protected array $fields) {}

            public function uniqueName(): string
            {
                return $this->fields['name'];
            }

            public function displayLabel(): string
            {
                return $this->fields['display_name'];
            }

        };
    }
}

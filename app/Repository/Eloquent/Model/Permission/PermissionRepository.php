<?php

namespace App\Repository\Eloquent\Model\Permission;

use App\Repository\Eloquent\Model\Permission\Pipeline\Search\PermissionSearch;
use App\Repository\Enum\Permission\SearchFields;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\Permission\IPermissionRepository;
use App\Repository\Interfaces\Model\Permission\IPermissionStoreDTO;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PermissionRepository implements IPermissionRepository
{
    public function __construct(private PermissionStoreFields $permissionStoreFields, private PermissionSearch $permissionSearch) {}

    public function store(IPermissionStoreDTO $permissionStoreDTO): IPermission
    {
        return Permission::create($this->permissionStoreFields->toArray($permissionStoreDTO));
    }

    public function updateDisplayLabel(IPermission $permission, string $displayLabel): void
    {
        $fields = [];

        $this->permissionStoreFields->addDisplayLabel($displayLabel, $fields);

        $this->update($permission, $fields);
    }

    public function find(array $searchFields): IPermission
    {
        if (Arr::hasAny($searchFields, [(SearchFields::ID)->value, (SearchFields::NAME)->value])) {
            return $this->permissionSearch->find($this->builder(), $searchFields);
        }

        throw new ObjectNotFoundException("Invalid Search Fields");
    }

    public function search(array $searchFields): Paginator|Collection
    {
        return $this->permissionSearch->search($this->builder(), $searchFields);
    }

    protected function update(Permission $permission, array $fields): bool
    {
        $updated = $permission->update($fields);

        $permission->refresh();

        return $updated;
    }

    protected function builder(): Builder
    {
        return Permission::query();
    }

}

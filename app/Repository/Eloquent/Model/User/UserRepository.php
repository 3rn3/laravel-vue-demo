<?php

namespace App\Repository\Eloquent\Model\User;

use App\Repository\Eloquent\Model\User\Pipeline\Search\UserSearch;
use App\Repository\Enum\User\SearchFields;
use App\Repository\Exceptions\ObjectNotFoundException;
use App\Repository\Interfaces\Model\Permission\IPermission;
use App\Repository\Interfaces\Model\User\IUser;
use App\Repository\Interfaces\Model\User\IUserRepository;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class UserRepository implements IUserRepository
{
    public function __construct(private UserStoreFields $userStoreFields, private UserSearch $userSearch) {}

    public function store(IUserStoreDTO $userStoreDTO): IUser
    {
        return User::create($this->userStoreFields->toArray($userStoreDTO));
    }

    public function updateName(IUser $user, string $name): void
    {
        $fields = [];

        $this->userStoreFields->addName($name, $fields);

        $this->update($user, $fields);
    }

    public function updateEmail(IUser $user, string $email): void
    {
        $fields = [];

        $this->userStoreFields->addEmail($email, $fields);

        $this->update($user, $fields);
    }

    public function updatePassword(IUser $user, string $password): void
    {
        $fields = [];

        $this->userStoreFields->addPassword($password, $fields);

        $this->update($user, $fields);
    }

    public function enable(IUser $user): void
    {
        $fields = [];

        $this->userStoreFields->addIsActive(true, $fields);

        $this->update($user, $fields);
    }

    public function disable(IUser $user): void
    {
        $fields = [];

        $this->userStoreFields->addIsActive(false, $fields);

        $this->update($user, $fields);
    }

    public function addPermission(IUser $user, IPermission $permission): void
    {
        $user->permissions()->attach($permission->getId());
    }

    public function removePermission(IUser $user, IPermission $permission): void
    {
        $user->permissions()->detach($permission->getId());
    }

    public function syncPermissions(IUser $user, int ...$permissions): void
    {
        $user->permissions()->sync($permissions);
    }

    public function find(array $searchFields): IUser
    {
        if (Arr::hasAny($searchFields, [(SearchFields::ID)->value, (SearchFields::EMAIL)->value, (SearchFields::NAME)->value])) {
            return $this->userSearch->find($this->builder(), $searchFields);
        }

        throw new ObjectNotFoundException("Invalid Search Fields");
    }

    public function search(array $searchFields): Paginator|Collection
    {
        return $this->userSearch->search($this->builder(), $searchFields);
    }


    public function update(User $user, array $fields): bool
    {
        $updated = $user->update($fields);

        $user->refresh();

        return $updated;
    }

    protected function builder(): Builder
    {
        return User::query();
    }

}

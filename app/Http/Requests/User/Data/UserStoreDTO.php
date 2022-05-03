<?php

namespace App\Http\Requests\User\Data;

use App\Http\Requests\User\Data\Helpers\Email;
use App\Http\Requests\User\Data\Helpers\Name;
use App\Http\Requests\User\Data\Helpers\Password;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use Illuminate\Http\Request;

class UserStoreDTO implements IUserStoreDTO
{
    public function __construct(protected Request $request, protected Name $nameHelper, protected Email $emailHelper, protected Password $passwordHelper) {}

    public function name(): string
    {
        return $this->nameHelper->getName($this->request);
    }

    public function email(): string
    {
        return $this->emailHelper->getEmail($this->request);
    }

    public function password(): string
    {
        return $this->passwordHelper->getPassword($this->request);
    }

    public function isActive(): bool
    {
        return true;
    }
}

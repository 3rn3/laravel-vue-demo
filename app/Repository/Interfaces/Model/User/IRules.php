<?php

namespace App\Repository\Interfaces\Model\User;

use Illuminate\Validation\Rules\Unique;

interface IRules
{
    public function uniqueEmail(IUser $ignoreUser = null): Unique;
}

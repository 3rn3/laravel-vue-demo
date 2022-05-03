<?php

namespace App\Http\Resources\User;

use App\Http\Requests\User\Enum\UserFields;
use App\Repository\Interfaces\Model\User\IUser;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @see IUser
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            (UserFields::ID)->value => $this->getId(),
            (UserFields::NAME)->value => $this->getName(),
            (UserFields::EMAIL)->value => $this->getEmail(),
            (UserFields::ACTIVE)->value => $this->isActive(),
        ];
    }
}

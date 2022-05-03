<?php

namespace App\Http\Resources\Permission;

use App\Repository\Interfaces\Model\Permission\IPermission;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @see IPermission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->getId(),
            'display_name' => $this->getDisplayLabel(),
            'unique_name' => $this->getUniqueName(),
        ];
    }
}

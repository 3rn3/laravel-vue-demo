<?php

namespace App\Http\Requests\User;

use App\Http\Requests\User\Data\Helpers\Permissions;
use App\Http\Requests\User\Validation\Validate;
use Illuminate\Foundation\Http\FormRequest;

class PermissionSyncRequest extends FormRequest
{
    public function __construct(protected Permissions $permissionHelper, private readonly Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $this->validate->addPermissionsRules($this, $rules);

        return $rules;
    }

    public function permissions(): array
    {
        return $this->permissionHelper->getPermissions($this);
    }
}

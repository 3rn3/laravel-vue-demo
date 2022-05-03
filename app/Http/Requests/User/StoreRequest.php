<?php

namespace App\Http\Requests\User;

use App\Http\Requests\User\Data\Helpers\Email;
use App\Http\Requests\User\Data\Helpers\Name;
use App\Http\Requests\User\Data\Helpers\Password;
use App\Http\Requests\User\Data\Helpers\Permissions;
use App\Http\Requests\User\Data\UserStoreDTO;
use App\Http\Requests\User\Validation\Validate;
use App\Repository\Interfaces\Model\User\IUserStoreDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function __construct(protected Name $nameHelper, protected Email $emailHelper, protected Password $passwordHelper, protected Permissions $permissionsHelper, private readonly Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
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
        return $this->validate->userStoreValidate($this);
    }

    public function userStoreDTO(): IUserStoreDTO
    {
        return new UserStoreDTO($this, $this->nameHelper, $this->emailHelper, $this->passwordHelper);
    }

    public function permissions(): array
    {
        return $this->permissionsHelper->getPermissions($this);
    }
}

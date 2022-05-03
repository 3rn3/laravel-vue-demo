<?php

namespace App\Http\Requests\User;

use App\Http\Requests\User\Data\Helpers\Email;
use App\Http\Requests\User\Validation\Validate;
use App\Repository\Interfaces\Model\User\IUser;
use App\Routes\RouteKey;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    protected IUser $user;

    public function __construct(protected Email $emailHelper, private readonly Validate $validate, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->user = request()->route((RouteKey::USER_ID)->value);
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

        $this->validate->addEmailRules($rules, $this->user);

        return $rules;
    }

    public function email(): string
    {
        return $this->emailHelper->getEmail($this);
    }
}

<?php
namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{

    public function rules()
    {
        $usernameAdditionalRule = Rule::unique('users', 'username');

        if ($this->user) {
            $usernameAdditionalRule = $usernameAdditionalRule->ignore($this->user->id);
        }

        return [
            'username' => [
                'required',
                $usernameAdditionalRule,
            ],
            'password' => 'required|confirmed',
            'role' => [
                'required',
                Rule::in(collect(app('roleService')->roles)->map->value()->toArray())
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }

    public function messages()
    {
        return [
            'role.in' => 'Role should be either admin, product_owner, or dev',
        ];
    }
}

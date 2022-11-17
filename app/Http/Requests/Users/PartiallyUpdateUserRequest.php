<?php
namespace App\Http\Requests\Users;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PartiallyUpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => [
                'sometimes',
                Rule::unique('users', 'username')->ignore($this->user->id)
            ],
            'password' => 'sometimes|confirmed',
            'role' => [
                'sometimes',
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

<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'       => 'required|max:255',
            'username' => 'required|string|regex:/\w*$/|max:255|unique:users,username', // 'required|max:255',
            'password'       =>  [
            'required',
            'string',
            'min:6',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ],
        ];
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
     * @return array
     * Custom validation message
     */
    public function messages(): array
    {
        return [
            'name.required'  => 'Please give user name',
            'name.max'       => 'Please give user name maximum of 255 characters',
            'username.required'  => 'Please give user username',
            'username.unique'  => 'Please give user unique username',
            'password.required'  => 'Please give user password',
            'password.min'  => 'Please give user password minimum of 6 characters'
        ];
    }
}
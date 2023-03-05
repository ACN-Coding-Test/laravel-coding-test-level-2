<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'unique:users,username',
                'max:255'
            ],
            'password' => [
                'required',
                'min:6'
            ],
            'password_confirmed' => [
                'required',
                'min:6',
                'same:password'
            ],
            'role_id' => [
                'required'
            ],
        ];
    }
}

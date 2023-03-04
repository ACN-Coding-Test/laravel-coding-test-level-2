<?php

namespace App\Http\Requests\User;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Support\Facades\Validator;

class CreateRequest extends CustomFormRequest
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
        Validator::extend('without_spaces', function ($attr, $value) {
            return preg_match('/^\S*$/u', $value);
        }, 'While space not allowed');

        return [
            'name' => 'required|required',
            'username' => 'required|without_spaces|string|unique:users,username',
            'password' => 'required|string|min:8',
            'role' => 'sometimes|string'
        ];
    }
}

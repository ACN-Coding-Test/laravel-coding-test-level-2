<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [];

        $rules['username'] = ['required' , 'min:3' , 'max:255' , 'unique:users,username'];
        $rules['password'] = ['required' , 'confirmed', 'min:6'];
        $rules['role_id'] = ['required', 'exists:roles,id'];

        return $rules;
    }

      /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {

        $messages = [];

        $messages['username.required']  = __("The :name field is required", ["name" => __("Username")]);
        $messages['username.min:3']  = __("The :name field must contain at least 3 character", ["name" => __("Username")]);
        $messages['username.max:255']  = __("The :name field cannot exceed 255 character", ["name" => __("Username")]);
        $messages['username.unique:users,username']  = __("The :name has already been taken", ["name" => __("Username")]);

        $messages['password.required']  = __("The :name field is required", ["name" => __("Password")]);
        $messages['password.min:6']  = __("The :name must contain at least 6 character", ["name" => __("Password")]);

        $messages['role_id.required']  = __("The :name field is required", ["name" => __("Role")]);
        $messages['role_id.exists']  = __("The :name not exist", ["name" => __("Role")]);

        return $messages;

    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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

        $rules['name'] = ['required', 'string', 'unique:projects,name'];

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

        $messages['name.required']  = __("The :name field is required", ["name" => __("Name")]);
        $messages['name.string']  = __("The :name field must be a string", ["name" => __("Name")]);
        $messages['nmae.unique']  = __("The :name has already been taken", ["name" => __("Name")]);

        return $messages;

    }
}
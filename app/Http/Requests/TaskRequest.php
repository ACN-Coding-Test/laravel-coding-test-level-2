<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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

        $rules['title'] = ['required', 'string'];
        $rules['description'] = ['string'];
        $rules['status'] = ['required', 'string'];
        $rules['project_id'] = ['required', 'exists:projects,id'];
        $rules['user_id'] = ['required', 'exists:users,id'];
       if ($this->isMethod('put') || $this->isMethod('patch')) {
            foreach($rules as $key=>$rule) {
                array_unshift($rule,'sometimes');
                $rules[$key]=$rule;
            }
        }

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

        $messages['title.required']  = __("The :name field is required", ["name" => __("Title")]);
        $messages['title.string']  = __("The :name field must be a string", ["name" => __("Title")]);

        $messages['description.string']  = __("The :name field must be a string", ["name" => __("Description")]);

        $messages['status.required']  = __("The :name field is required", ["name" => __("Status")]);
        $messages['status.string']  = __("The :name field must be a string", ["name" => __("Status")]);

        $messages['project_id.required']  = __("The :name field is required", ["name" => __("Project ID")]);
        $messages['project_id.exists']  = __("The :name not exist", ["name" => __("Project ID")]);

        $messages['user_id.required']  = __("The :name field is required", ["name" => __("user ID")]);
        $messages['user_id.exists']  = __("The :name not exist", ["name" => __("User ID")]);

        return $messages;

    }
}
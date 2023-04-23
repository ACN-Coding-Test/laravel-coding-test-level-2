<?php

namespace App\Http\Requests;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|regex:/\w*$/|max:255|unique:project,name', 
        ];
    }

    /**
     * Determine if the project is authorized to make this request.
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
            'name.required'  => 'Please give project name',
            'name.max'       => 'Please give name name maximum of 255 characters',
        ];
    }
}
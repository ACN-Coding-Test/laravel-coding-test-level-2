<?php

namespace App\Http\Requests;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|max:255',
            'description'       => 'nullable|max:255',
            'status'       => 'required|max:255',
            // 'project_id'       => 'required|max:255',
            // 'user_id'       => 'required|max:255',
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
            'title.required'  => 'Please give task title',
            'title.max'       => 'Please give task title maximum of 255 characters',
            'description.max' => 'Please give task description maximum of 5000 characters',            
            'status.required'  => 'Please give task status',
        ];
    }
}
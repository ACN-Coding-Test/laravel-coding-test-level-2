<?php

namespace App\Http\Requests;

use App\Models\Task;
use App\Helpers\ApiHelper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => [
                'required',
                'max:255'
            ],
            'description' => [
                'nullable',
                'max:255'
            ],
            'status' => [
                'required',
                'numeric',
                ApiHelper::getAllStatusTypeForValidation()
            ],
            'project_id' => [
                'required',
                'numeric',
            ],
            'user_id' => [
                'required',
                'numeric',
            ],
        ];
    }
}

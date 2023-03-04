<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\CustomFormRequest;

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
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'project_id' => 'required|integer|exists:App\Models\Project,id',
            'user_id' => 'sometimes|integer|exists:App\Models\User,id'
        ];
    }
}

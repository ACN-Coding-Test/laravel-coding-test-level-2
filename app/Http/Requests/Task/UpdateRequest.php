<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tittle' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'required|string|in:NOT_STARTED,IN_PROGRESS,READY_FOR_TEST,COMPLETED',
            'project_id' =>'sometimes|string',
            'user_id' => 'sometimes|string',
                // exists:users,id',

        ];
    }
}

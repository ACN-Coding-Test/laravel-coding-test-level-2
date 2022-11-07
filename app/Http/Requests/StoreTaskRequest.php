<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required|string',
            'description'   => 'nullable|string',
            'project_id'    => 'required|uuid',
            'user_id'       => 'required|uuid',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 401,
            'message'  => 'Validation errors',
            'errors'   => $validator->errors()
        ]));
    }
}

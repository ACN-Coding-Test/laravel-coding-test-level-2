<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title'=>'required|unique:tasks,title'
        ];

        if($this->method() == 'PATCH'){
            $rules = [];
        }

        return $rules;
    }

    /**
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'=>'failure',
            'message'=>'Validator errors',
            'data'=>$validator->errors()
        ]));
    }
}

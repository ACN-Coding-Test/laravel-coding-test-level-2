<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $rules =  [
            'username'=>'required|unique:users,username',
            'password'=>'required|min:8|confirmed',
        ];

        if($this->method() == 'PUT'){
            $rules['username'] = "unique:users,username";
        }

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

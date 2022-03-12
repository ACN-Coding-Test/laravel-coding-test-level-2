<?php

namespace App\Http\Requests\User;

use App\Models\User as ModelUser;
use Illuminate\Foundation\Http\FormRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;


class UpdateUser extends FormRequest
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->request = $request;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => ['required', Rule::unique('users')->ignore($this->username)],
            'password' => 'required', Password::min(8)
        ];
    }

    public function persist($id)
    {
        try {
            $user = ModelUser::findOrFail($id);
            $user->update(Request::all());
            return $user;
        } 
        catch (Exception $e) {
           return "This user do not exist";
        }
    }
}

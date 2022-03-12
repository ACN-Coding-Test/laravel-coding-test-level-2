<?php

namespace App\Http\Requests\User;

use App\Models\User as ModelUser;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;



class PatchUser extends FormRequest
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
            'username' => ['sometimes', Rule::unique('users')->ignore($this->username)],
            'password' => 'sometimes', Password::min(8)
        ];
    }

    public function persist($id)
    {
        try {
            $user = ModelUser::findOrFail($id);
            $user->update(Request::only('username', 'password'));
            return $user;
        } 
        catch (Exception $e) {
           return "This user do not exist";
        }

   
    }
}

<?php

namespace App\Http\Requests\User;

use App\Models\User as ModelUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class StoreUser extends FormRequest
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
            'username' => 'required|unique:users|max:255',
            'password' => ['required', Password::min(8), 'alpha_dash']
        ];
    }

    public function persist()
    {
        return ModelUser::create(Request::all());
    }
}

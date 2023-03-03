<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['username', 'password']))) {
            return $this->error('Createntials does not match.', 404);
        }

        $user = User::where('username', $request->username)->first();

        $data = ['token' => $user->createToken("token")->plainTextToken];
        return $this->success($data, 'Successfully Logged In');
    }

    public function logout()
    {
        if(Auth::user()->tokens()->delete()){
            return $this->success([], 'Successfully Logged Out');
        }

        return $this->error('Successfully Logged Out', 404);
    }
}

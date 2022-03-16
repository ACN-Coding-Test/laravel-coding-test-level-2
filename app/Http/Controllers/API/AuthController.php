<?php

namespace App\Http\Controllers\API;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:55|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Admin',
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        if (!auth()->attempt($data)) {
            return response(['message' => 'Login credentials are invaild']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['access_token' => $accessToken]);

    }
}
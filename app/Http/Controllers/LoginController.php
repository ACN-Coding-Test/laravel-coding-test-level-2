<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        $credentials = request()->validate(
            [
                'username' => 'required',
                'password' => 'required'
            ]
        );

        // $data = $this->user_service->login($credentials);

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials.']);
        }

        $user = auth()->user();

        $accessToken = $user->createToken('authToken');

        $data = [
            'user' => $user,
            'accessToken' => $accessToken->plainTextToken
        ];

        return response()->json($data);
    }
}

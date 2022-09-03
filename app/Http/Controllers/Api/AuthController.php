<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->only('username','password'))){
            return response([
               'errors' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'jwt'=>$token
        ]);
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response([
            'message'=>'Successfully logged out'
        ]);
    }
}

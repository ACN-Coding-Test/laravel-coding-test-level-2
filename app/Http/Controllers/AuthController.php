<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Traits\ResponseTrait;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
     
        if(!Auth::attempt($credentials)){
            return ResponseTrait::sendResponse(null,0,'Invalid credentials',400);

        }
        

        $generate_token = User::generateToken($request);

        return($generate_token);
    }
}

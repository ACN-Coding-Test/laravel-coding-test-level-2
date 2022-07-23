<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->user = new User();
    }

    public function login(Request $request){
        if (!\Auth::attempt($request->only('email', 'password'))) {
               return response()->json([
                'message' => 'Login information is invalid.'
              ], 401);
        }
 
        $user = User::where('email', $request['email'])->firstOrFail();
                $token = $user->createToken('authToken')->plainTextToken;
 

        if(!$token) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            ],1,'Success',200);
    }
    // public function logout()
    // {
    //     Auth::logout();
    //     return response()->json([
    //         'message' => 'successfully logout',
    //         ]);
    // }
}

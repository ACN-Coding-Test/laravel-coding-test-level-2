<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $req) {
        $fields = $req->validate([
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('$3cr37')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token,
        ];

        return response($res, 201);
    }

    public function login(Request $req) {
        $fields = $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Check username
        $user = User::where('username', $fields['username'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid creds'
            ], 401);
        }

        $token = $user->createToken('$3cr37')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token,
        ];

        return response($res, 201);
    }

    public function logout(Request $req) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Successfully logged out',
        ]; 
    }
}

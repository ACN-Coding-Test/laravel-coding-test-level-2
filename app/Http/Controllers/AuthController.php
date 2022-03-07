<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        // $user = User::create([
        //     'username'=> $fields['username'],
        //     'email'=> $fields['email'],
        //     'passowrd'=> bcrypt($fields['password']),

        // ]);
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();
        $token = $user->createToken('myprojecttoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        $role = Role::select('id')->where('name','user')->first();

        $user->roles()->attach($role);

        return response($user, 201);
    }
    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string|',
            'password' => 'required|string|',
        ]);

    
        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password)){
          return response([
              'message'=> 'bad creds'
          ],401);
        }

        $token = $user->createToken('myprojecttoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }
}

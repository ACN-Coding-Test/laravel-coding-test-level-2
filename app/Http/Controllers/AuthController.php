<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController as BaseController;

class AuthController extends BaseController
{
    public function registerAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $password = Hash::make($request->password);
        $uuid=Str::orderedUuid();

        $user = User::create([
            'id' => $uuid,
            'name' => $request->name,
            'username' => $request->username,
            'password' => $password,
            'role' => "ADMIN",
            'type' => "ADMIN"
        ]);

        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }

    public function authToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $auth=Auth::attempt(['username' => $request->username, 'password' => $request->password]);

        if($auth){
            $token='MindGraph'.$request->email;
            $user = Auth::user(); 
            $success['token'] =  $user->createToken($token) -> accessToken; 
            $success['name'] =  $user->name;
            $success['role'] =  $user->role;
   
            return $this->sendResponse($success, 'Authentication Successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}

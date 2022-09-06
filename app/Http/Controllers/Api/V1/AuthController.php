<?php
namespace App\Http\Controllers\Api\V1;
use App\Models\User;
use App\Http\Controllers\Api\V1\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (!Auth::attempt($data)) {
            return $this->sendError('Unauthorised.',array('error'=>'Invalid login details'));
        }
        $user = User::where('username', $request['username'])->firstOrFail();
        $success['access_token'] =  auth('api')->user()->createToken('auth_token')->plainTextToken;
        $success['token_type'] =  'Bearer';
        return $success;
    }

    public function logout (Request $request) {

        auth('api')->user()->currentAccessToken()->delete();
        return response(['message' => 'You have been successfully logged out.'], 200);
    }
}

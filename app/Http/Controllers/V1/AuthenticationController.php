<?php

namespace App\Http\Controllers\V1;

use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthenticationController extends Controller
{
    /**
     * Register the logging user
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'username' => $request->input('username'),
                'password' => bcrypt($request->input('password')),
                'role_id' => Role::ROLE_TYPE_ADMIN,
            ]
        );

        return response($user);
    }

    /**
     * Logged the user
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        // NOTE :- this will not work with test cases
        // $attempt = Auth::attempt(
        //     $request->only(
        //         'username',
        //         'password'
        //     )
        // );

        $attempt = Auth::guard('api')->attempt(
            $request->only(
                'username',
                'password'
            )
        );

        if(!$attempt) {
            return response(
                [
                    'errors' => 'Invalid Credentials'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return response(
            [
                'jwt' => $token
            ]
        );
    }

    /**
     * Logout the user
     * 
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout (Request $request) {
        auth()->user()->currentAccessToken()->delete();

        // if(Auth::check()) {
        //     // $token = request()->bearerToken();
        //     // auth()->user()->tokens()->where('id', $tokenId )->delete();

        //     // $tokenId = Str::before(request()->bearerToken(), '|');
        //     // Auth::user()->tokens()->where('id', $tokenId)->delete();

        //     auth()->user()->tokens->each(function ($token, $key) {
        //         $token->delete();
        //     });
        // }

        return response(
            [
                'message' => 'You have been successfully logged out.'
            ]
        , 200);
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request  $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        $auth = Auth::attempt(['username' => $request->username, 'password' => $request->password]);

        if ($auth){
            $user = Auth::user();
            $token = $user->createToken($request->email)->accessToken;

            return response()->json([
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                    'roles' => $user->getRoles(),
                ]
            ]);
        }  else {
            $this->incrementLoginAttempts($request);
            return response()->json([
                'error' => 'Incorrect login.'
            ], 401);
        }

        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {


        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function validateLogin($request)
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }
}

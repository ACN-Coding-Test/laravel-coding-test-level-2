<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthServices
{
    public function login($input)
    {
        try {
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $user = auth()->user();
                $token = $user->createToken($user->id);
                
                return $token->plainTextToken;
            }
        } catch (\Exception $e) {
            Log::error('(Error) Login failed. Error: ' . PHP_EOL . $e->getMessage());
            throw new \Exception('Login failed.');
        }
    }
}
<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ValidationHelper;
use App\Services\AuthServices;

class LoginController extends BaseController
{
    public $authService;

    public function __construct()
    {
        $this->authService = new AuthServices();
    }
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, ValidationHelper::getLoginRules());

        if ($validator->fails()) {
            return $this->sendError('Unprocessable Entity.', $validator->errors(), 422);
        }

        try {
            $token = $this->authService->login($input);
            return $this->sendResponse('Login successfully', $token);
        } catch (\Exception $e) {
            return $this->sendError('Login failed.', $e->getMessage, 500);
        }
    }
}

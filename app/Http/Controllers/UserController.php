<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\UserServices;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ValidationHelper;

class UserController extends BaseController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserServices();
    }

    public function getUsers()
    {
        try {
            $data = $this->userService->getUsers();
            return $this->sendResponse('Retrieved users successfully', $data);
        } catch (\Exception $e) {
            return $this->sendError('Retrieved users failed.', $e->getMessage, 500);
        }
    }

    public function getUser(Request $request, $user_id)
    {
        try {
            $id = $user_id;
            $validator = Validator::make(
                [
                    'id' => $id
                ],
                [
                    'id' => 'required|uuid|exists:users,id'
                ]
            );

            if ($validator->fails()) {
                return $this->sendError('Unprocessable Entity.', $validator->errors(), 422);
            }

            $data = $this->userService->getUser($id);
            return $this->sendResponse('Retrieved user successfully', $data);
        } catch (\Exception $e) {
            return $this->sendError('Retrieved user failed.', $e->getMessage, 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($input, ValidationHelper::getCreateUserRules());
    
            if ($validator->fails()) {
                return $this->sendError('Unprocessable Entity.', $validator->errors(), 422);
            }

            $data = $this->userService->createUser($input);
            return $this->sendResponse('Created user successfully', $data);
        } catch (\Exception $e) {
            return $this->sendError('Create user failed', $e->getMessage());
        }
    }

    public function updateUser(Request $request, $user_id)
    {
        try {
            $input = $request->all();
            $input['id'] = $user_id;
            $validator = Validator::make($input, ValidationHelper::getUpdateUserRules());

            if ($validator->fails()) {
                return $this->sendError('Unprocessable Entity.', $validator->errors(), 422);
            }

            $data = $this->userService->updateUser($input);
            return $this->sendResponse('Updated user successfully', $data);
        } catch (\Exception $e) {
            return $this->sendError('Updated user failed.', $e->getMessage, 500);
        }
    }

    public function deleteUser(Request $request, $user_id)
    {
        try {
            $id = $user_id;
            $validator = Validator::make(
                [
                    'id' => $id
                ],
                [
                    'id' => 'required|uuid|exists:users,id'
                ]
            );

            if ($validator->fails()) {
                return $this->sendError('Unprocessable Entity.', $validator->errors(), 422);
            }

            $data = $this->userService->deleteUser($id);
            return $this->sendResponse('Deleted user successfully');
        } catch (\Exception $e) {
            return $this->sendError('Deleted user failed.', $e->getMessage, 500);
        }
    }
}

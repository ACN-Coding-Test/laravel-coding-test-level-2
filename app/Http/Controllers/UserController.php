<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Response trait to handle return responses.
     */
    use ResponseTrait;

    /**
     * User related functionalities.
     *
     * @var UserRepository
     */
    public $userRepository;

    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct(UserRepository $ar)
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userRepository = $ar;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->userRepository->getAll();
            return $this->responseSuccess($data, 'User List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->create($request->all());
            return $this->responseSuccess($user, 'New User Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show($id): JsonResponse
    {
        try {
            $data = $this->userRepository->getByID($id);
            if (is_null($data)) {
                return $this->responseError(null, 'User Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseSuccess($data, 'User Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        try {
            $data = $this->userRepository->update($id, $request->all());
            if (is_null($data))
                return $this->responseError(null, 'User Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseSuccess($data, 'User Updated Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

  	public function destroy($id): JsonResponse
	    {
	        try {
	            $user =  $this->userRepository->getByID($id);
	            if (empty($user)) {
	                return $this->responseError(null, 'User Not Found', Response::HTTP_NOT_FOUND);
	            }

	            $deleted = $this->userRepository->delete($id);
	            if (!$deleted) {
	                return $this->responseError(null, 'Failed to delete the user.', Response::HTTP_INTERNAL_SERVER_ERROR);
	            }

	            return $this->responseSuccess($user, 'User Deleted Successfully !');
	        } catch (\Exception $e) {
	            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
	        }
    }



    public function me(): JsonResponse
    {
        try {
            $data = $this->guard()->user();
            return $this->responseSuccess($data, 'Profile Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
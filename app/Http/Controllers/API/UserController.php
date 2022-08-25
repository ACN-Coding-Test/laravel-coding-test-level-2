<?php

namespace App\Http\Controllers\API;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Validator;

class UserController extends Controller
{
    public function __construct(Request $request) {
        if($request->username != 'Admin'){
            return Response::deny('You must be an administrator to continue accessing users.');
        }
    }
    
    public function index()
    {
        $Users = User::all();
        return response(['Users' => UserResource::collection($Users)]);
    }

    private function checkUserRole()
    {
        if(auth('api')->user()->role != 'Admin'){
            return false;
        }
        return true;
    }
    public function store(Request $request)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a Admin to continue using users.');
        }
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $User = User::create($data);

        return response(['User' => new UserResource($User), 'message' => 'User created successfully']);
    }

    public function show(User $User)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a Admin to continue using users.');
        }
        return response(['User' => new UserResource($User)]);
    }

    public function update(Request $request, User $User)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a Admin to continue using users.');
        }
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $User->update($data);

        return response(['User' => new UserResource($User), 'message' => 'User updated successfully']);
    }

    public function destroy(User $User)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a Admin to continue using users.');
        }
        $User->delete();

        return response(['message' => 'User deleted successfully']);
    }
}

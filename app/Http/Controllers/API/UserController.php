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
    public function index()
    {
        $Users = User::all();
        return response(['Users' => UserResource::collection($Users)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $User = User::create($data);

        return response(['User' => new UserResource($User), 'message' => 'User created successfully']);
    }

    public function show(User $User)
    {
        return response(['User' => new UserResource($User)]);
    }

    public function update(Request $request, User $User)
    {
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
        $User->delete();

        return response(['message' => 'User deleted successfully']);
    }
} 
<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return ModelResource::collection($users);
    }

    public function show(User $user)
    {
        return new ModelResource($user);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return new ModelResource($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return new ModelResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
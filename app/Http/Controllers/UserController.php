<?php

namespace App\Http\Controllers;

use App\Dto\CreateUserDto;
use App\Dto\UpdateUserDto;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\PartiallyUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Users\CreateUser;
use App\Services\Users\UpdateUserWithPatch;
use App\Services\Users\UpdateUserWithPut;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(CreateUserRequest $request, CreateUser $createUserService)
    {
        $user = $createUserService->execute(
            new CreateUserDto(
                username: $request->input('username'),
                password: $request->input('password'),
                role: $request->input('role')
            ));

        return UserResource::make($user);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    // definitely personal choice here to use CreateUserRequest instead of creating other form request
    // as i think it would be quite similar
    public function updateWithPut(CreateUserRequest $request, User $user, UpdateUserWithPut $updateUserWithPut)
    {
        $user = $updateUserWithPut->execute(
            $user,
            new CreateUserDto(
                username: $request->input('username'),
                password: $request->input('password'),
                role: $request->input('role'),
            )
        );

        return UserResource::make($user);
    }

    public function updateWithPatch(PartiallyUpdateUserRequest $request, User $user, UpdateUserWithPatch $updateUserWithPatch)
    {
        $user = $updateUserWithPatch->execute(
            $user,
            new UpdateUserDto(
                username: $request->input('username'),
                password: $request->input('password'),
                role: $request->input('role'),
            )
        );

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => $user->username . ' has been deleted!',
            'success' => true
        ]);
    }
}

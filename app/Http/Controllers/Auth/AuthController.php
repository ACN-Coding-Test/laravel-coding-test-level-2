<?php
namespace App\Http\Controllers\Auth;

use App\Dto\CreateUserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\Users\CreateUser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request, CreateUser $createUserService)
    {
        $user = $createUserService->execute(
            new CreateUserDto(
                username: $request->input('username'),
                password: $request->input('password'),
                role: $request->input('role')
            )
        );

        return AuthUserResource::make($user);
    }

    public function store(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        abort_if(!$user || !Hash::check($request->password, $user->password), 404, 'User not found!');

        return AuthUserResource::make($user);
    }
}

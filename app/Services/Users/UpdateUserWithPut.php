<?php
namespace App\Services\Users;

use App\Dto\CreateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserWithPut
{
    public function execute(User $user, CreateUserDto $createUserDto): User
    {
        $user->username = $createUserDto->username;
        $user->password = Hash::make($createUserDto->password);
        $user->role = $createUserDto->role;
        $user->timestamps = false;
        $user->save();

        return $user;
    }
}

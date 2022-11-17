<?php
namespace App\Services\Users;

use App\Dto\CreateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function execute(CreateUserDto $createUserDto): User
    {
        return User::create([
            'username' => $createUserDto->username,
            'password' => Hash::make($createUserDto->password),
            'role' => $createUserDto->role,
        ]);
    }
}

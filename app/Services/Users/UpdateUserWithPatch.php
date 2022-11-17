<?php
namespace App\Services\Users;

use App\Dto\UpdateUserDto;
use App\Models\User;

class UpdateUserWithPatch
{
    public function execute(User $user, UpdateUserDto $updateUserDto): User
    {
        $sanitizedValue = array_filter($updateUserDto->toArray(), fn ($value) => $value);

        $user->update($sanitizedValue);

        return $user;
    }
}

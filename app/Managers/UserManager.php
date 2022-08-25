<?php

namespace App\Managers;

use App\Models\User;
use Ramsey\Uuid\Uuid;

/**
 * Class FullTimeStep1Service.
 */
class UserManager
{
    public function store(array $input, User $user = null) : User {

        if (!$user) {
            $user = User::create([
                'email' => $input['email'],
                'name' => $input['name'],
                'role_id'  => $input['role_id'],
            ]);
        } else {
            $user->fill([
                'email' => $input['email'],
                'name' => $input['name'],
                'role_id'  => $input['role_id'],
            ]);

        }
        if (isset($input['password'])) {
            $user->password = bcrypt($input['password']);
        }
        $user->save();
        return $user;
    }
}
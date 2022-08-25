<?php

namespace App\Managers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class FullTimeStep1Service.
 */
class UserManager
{
    public function store(array $input, User $user = null) : User {


        if (!$user) {
            $user = User::create([
                'email' => $input['email'],
                'username' => $input['username'],
                'name' => $input['name'],
                'role_id'  => $input['role_id'],
            ]);
        } else {
            $user->fill([
                'email' => $input['email'],
                'name' => $input['name'],
                'username' => $input['username'],
                'role_id'  => $input['role_id'],
            ]);

        }
        if (isset($input['password'])) {
            $user->password = Hash::make($input['password']);
        }
        $user->save();
        return $user;
    }
}
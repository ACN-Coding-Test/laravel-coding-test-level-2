<?php

namespace App\Managers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class FullTimeStep1Service.
 */
class UserManager
{
    public function store($input, $user = null) : User {


        if (!$user) {
            var_dump("hi");
            $user = User::create([
                'email' => $input['email'],
                'username' => $input['username'],
                'name' => $input['name'],
                'role_id'  => $input['role_id'],
            ]);
        } else {
            $fillables = ['email','name','username','role_id'];
            foreach ($fillables as $key => $value) {
                if (isset($input[$value])) {
                    $user->fill([
                        $value => $input[$value]
                    ]);
                }
            }


        }
        if (isset($input['password'])) {
            $user->password = Hash::make($input['password']);
        }
        $user->save();
        return $user;
    }
}
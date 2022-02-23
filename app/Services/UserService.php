<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUsers()
    {
        $users = User::get();
    
        return $users;
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return ['messages' => 'User not found'];
        }

        return $user;
    }

    public function createNewUser($request)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email
        ];

        $createUser = User::create($data);
        
        return $createUser;
    }

    public function updateUser($request, $id)
    {
        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];
        
        $user = User::find($id);
        if (!$user) {
            return 'User not found';
        }
        $updateUser = $user->update($data);
        
        return 'Successfully update user ';
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return 'User not found';
        }
        $user->delete($id);

        return 'Successfully deleted user.';
    }
}
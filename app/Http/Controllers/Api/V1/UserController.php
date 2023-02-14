<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /* function to fetch all users */
    public function index()
    {
        return User::all();
    }

    /* function to fetch user for which id given in route */
    public function showUser($id)
    {
        return User::find($id);
    }

    /* function to create new user */
    public function createUser()
    {
        $data = [
            ['name'=>'Jason1', 'email'=> 'json@gmail.com', 'password' => '123']
        ];
        
        User::insert($data);
         
        echo  "record inserted";
    }

    /* function to update user with specific Id */
    public function updateUser(Request $request)
    {
        $id = $request->id;
        $data = ['name'=>'Jason2', 'email'=> 'json1@gmail.com', 'password' => '1234'];
        
        User::where(['id'=>$id])
                  ->update($data);
        return User::find($id);
    }

    /* function to delete user with given Id */
    public function deleteUser(Request $request)
    {
        $id = $request->id;
        User::where(['id'=>$id])
                  ->delete();
        echo "User deleted successfully";
    }
}

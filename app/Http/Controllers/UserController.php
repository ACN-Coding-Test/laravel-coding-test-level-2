<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
  
    public function index()
    {
        return User::all();
    }


    public function store(Request $request)
    {
        // validate
        $user = User::create([
            'username'=>$request->username,
            'password'=>bcrypt($request->password)
        ]);
        return $user;
    }

    public function show(User $user)
    {
      return $user;
    }


    public function update(Request $request, User $user)
    {

        $user->username=$request->username;
        $user->password=bcrypt($request->password);
        $user->save();
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json('User Deleted');
    }
}

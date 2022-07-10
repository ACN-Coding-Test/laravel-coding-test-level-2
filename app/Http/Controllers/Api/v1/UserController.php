<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function show($user)
    {
        return User::find($user);
    }
    public function create(Request $req)
    {
        $user = new User;
        $user->username=$req->username;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->role=$req->role;
        $user->password= $req->password;
        $result=$user->save();
        if($result) {
          return 'file created';
        }
        else {
          return 'failed';
        }
    }
    public function update(Request $req , $user)
    {
        $user = User::find($user);
        $user->username=$req->username;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->role=$req->role;
        $user->password=$req->password;
        $result=$user->save();

        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function patch(Request $req , $user)
    {
        $user = User::find($user);
        if($req->username)
        {
          $user->username=$req->username;
        }
        if($req->name)
        {
          $user->name=$req->name;
        }
        if($req->email)
        {
          $user->email=$req->email;
        }
        if($req->role)
        {
          $user->role=$req->role;
        }
        if($req->password)
        {
          $user->password=$req->password;
        }
        $result=$user->save();
        if($result)
        {
            return 'file updated';
        }
        else
        {
            return 'failed';
        }
    }
    public function destroy($user)
    {
      $user = User::find($user);
      $result = $user->delete();
      if($result){
        return "records has been deleted";
      }
      else {
        return "error";
      }
    }
}

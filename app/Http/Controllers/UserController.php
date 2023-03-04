<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function getresources($id=null){
        if($id){
            $result = User::find($id);
        }else{
            $result = User::all();
        }
        
        if((!empty($result)) && (count($result)>0)){
             return $result;
        }else{
            return response()->json(['message'=>'No Data Found']);
        }
    }

    function createresource(Request $req){
        $user = new User;
        $user->name=$req->input('name');
        $user->email=$req->input('email');
        $user->password=md5($req->input('password'));
        $user->save();
        return $user;
    }

    function updateresource(Request $req){
        $user = User::find($req->id);
        $user->name=$req->input('name');
        $user->email->$req->input('email');
        $result=$device->save();

        if($result){
            return response()->json(['message'=>'Successfully Updated']);
        }else{
            return response()->json(['message'=>'Update Failed']);
        }
    }

    function deleteresource(Request $req){
        $user = User::find($req->id);
        $result = $user->delete();
        if($result){
            return response()->json(['message'=>'Successfully Deleted']);
        }else{
            return response()->json(['message'=>'Delete Failed']);
        }
    }


}

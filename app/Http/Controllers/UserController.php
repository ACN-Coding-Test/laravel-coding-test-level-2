<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use\Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function getresources($id=null){
        if(Gate::allows('isAdmin')){
            if($id){
                $result = User::find($id);
            }else{
                $result = User::all();
            }
            $data = json_decode($result, true);
            if(!empty($data)){
                 return $result;
            }else{
                return response()->json(['message'=>'No Data Found']);
            }
        }else{
            return response()->json(['message'=>'Only Admin is Allowed']);
        }
    }

    function createresource(Request $req){
        if(Gate::allows('isAdmin')){
            $input = $req->all();
            $input['password']=Hash::make($req->input('password'));
            $user = User::create($input);
            $response=[
                'user'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->role,
            ];
            return response($response,201);
        }else{
            return response()->json(['message'=>'Only Admin is Allowed']);
        }
    }

    function updateresource(Request $req){
        $user = User::find($req->id);
        if($user){
            if(Gate::allows('isAdmin')){
                $input = $req->all();
                $result=$user->update($input);
                if($result){
                    return response()->json(['message'=>'Successfully Updated']);
                }else{
                    return response()->json(['message'=>'Update Failed']);
                }
            }else{
                return response()->json(['message'=>'Only Admin is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid User']);
        }
    }

    function deleteresource(Request $req){
        $user = User::find($req->id);
        if($user){
            if(Gate::allows('isAdmin')){
                $result = $user->delete();
                if($result){
                    return response()->json(['message'=>'Successfully Deleted']);
                }else{
                    return response()->json(['message'=>'Delete Failed']);
                }
            }else{
                return response()->json(['message'=>'Only Admin is Allowed']);
            }
        }else{
                return response()->json(['message'=>'Invalid User']);
        }
    }

    function registerUser(Request $req){
        $user = new User;
        $user->name=$req->input('name');
        $user->email=$req->input('email');
        $user->password=Hash::make($req->input('password'));
        $user->save();
        $response=[
            'user'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->role,
        ];
        return response($response,201);
    }


    function login(Request $req){
        $user = User::where('email', $req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return response([
            'message' => ['These credentials do not match our records.']
            ], 404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;
        $response = [
        'user' => $user,
        'token' => $token
        ];
        return response($response, 201);
    }

}

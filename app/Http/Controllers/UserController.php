<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    public function addUser(Request $request)
    {
        //dd('hai');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role' => 'required',
            'user_create' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $password = Hash::make($request->password);
        $uuid=Str::orderedUuid();

        
        $count=User::where('username',$request->user_create)->count();

        if($count>0){
            $checkUser=User::where('username',$request->user_create)->first();
            $user_create=$checkUser->role;
            if($user_create == 'ADMIN'){
                $user = User::create([
                    'id' => $uuid,
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => $password,
                    'role' => $request->role,
                    'type' => $request->role
                ]);
    
                $success['name'] =  $user->name;
       
                return $this->sendResponse($success, 'User register successfully.');
            }
            else{
                return $this->sendError('Validation Error.', 'You not have permission to register user');   
            }
        }
        else{
            return $this->sendError('Validation Error.', 'You not have permission to register user');
        }
    }

    public function getUser($id)
    {
        $count=User::where('id',$id)->count();
        if($count>0){
            $users=User::where('id',$id)->get();
            return $this->sendResponse($users, 'Successfully Parse User Data.');
        }
        else{
            return $this->sendError('ID is not Valid.', 'User Data Not Found');
        }
    }

    public function getAllUser()
    {
        $count=User::count();
        if($count>0){
            $users=User::get();
            return $this->sendResponse($users, 'Successfully Parse User Data.');
        }
        else{
            return $this->sendError('Table is empty.', 'User Data Not Found');
        }
    }

    public function putUser(Request $request,$id)
    {
        //dd($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'user_create' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $password = Hash::make($request->password);
        
        $count=User::where('username',$request->user_create)->count();

        if($count>0){
            $checkUser=User::where('username',$request->user_create)->first();
            $user_create=$checkUser->role;
            if($user_create == 'ADMIN'){
                $user = User::updateOrCreate(['id' => $id],[
                    'name' => $request->name,
                    'username' => $request->username,
                    'password' => $password,
                    'role' => $request->role,
                    'type' => $request->role
                ]);
    
                $success['name'] =  $user->name;
       
                return $this->sendResponse($success, 'User update successfully.');
            }
            else{
                return $this->sendError('Validation Error.', 'You not have permission to register user');   
            }
        }
        else{
            return $this->sendError('Validation Error.', 'You not have permission to register user');
        }
    }

    public function patchUser(Request $request,$id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
            'user_create' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $password = Hash::make($request->password);
        
        $count=User::where('username',$request->user_create)->count();

        if($count>0){
            $checkUser=User::where('username',$request->user_create)->first();
            $user_create=$checkUser->role;
            if($user_create == 'ADMIN'){
                $user = User::where('id',$id)->update([
                    'name' => $request->name,
                    'password' => $password,
                    'role' => $request->role,
                    'type' => $request->role
                ]);
    
                $success['id'] =  $id;
       
                return $this->sendResponse($success, 'User update successfully.');
            }
            else{
                return $this->sendError('Validation Error.', 'You not have permission to register user');   
            }
        }
        else{
            return $this->sendError('Validation Error.', 'You not have permission to register user');
        }
    }

    public function deleteUser($id)
    {
        $userDelete = User::find($id);
    	$userDelete->delete();

        $success['id'] =  $id;
   
        return $this->sendResponse($success, 'Successfully Delete an User.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Traits\ResponseTrait;

use App\Http\Requests\ValidateUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->user = new User();

    }

    public function getUsers(){

        $authUser = Auth::User();
        // dd($authUser);
        if($authUser['role'] == User::ADMIN){
            $users =  $this->user->index();
            if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);
            return ResponseTrait::sendResponse($users,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
        
    }

    public function getUserById($id){

        $authUser = Auth::User();
        // dd($authUser);
        if($authUser['role'] == User::ADMIN){
            $users =  $this->user->show($id);

            if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);

            return ResponseTrait::sendResponse($users,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }

    public function storeUser(ValidateUser $data){

        $authUser = Auth::User();
        // dd($authUser);
        if($authUser['role'] == User::ADMIN){
            $val_data = $data->validated();
            $users = $this->user->store($val_data);

            if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);

            return ResponseTrait::sendResponse($users,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }

    public function updateUser(Request $data, $id){
        $authUser = Auth::User();
        // dd($authUser);
        if($authUser['role'] == User::ADMIN){

            $users =  $this->user->updateUser($data, $id);

            if(!$users) return ResponseTrait::sendResponse($data,0,'Failed',422);

            return ResponseTrait::sendResponse($users,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }

    public function deleteUser($id){
        $authUser = Auth::User();
        // dd($authUser);
        if($authUser['role'] == User::ADMIN){
            $users =  $this->user->deleteUser($id);
            if(!$users) return ResponseTrait::sendResponse($users,0,'Failed',422);

            return ResponseTrait::sendResponse($users,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }
}

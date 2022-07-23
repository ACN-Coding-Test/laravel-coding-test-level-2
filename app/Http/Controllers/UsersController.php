<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Traits\ResponseTrait;

use App\Http\Requests\ValidateUser;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->user = new User();

    }

    public function getUsers(){

        $users =  $this->user->index();

        if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($users,1,'Success',200);
    }

    public function getUserById($id){

        $users =  $this->user->show($id);

        if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($users,1,'Success',200);
    }

    public function storeUser(ValidateUser $data){
        $val_data = $data->validated();
        // if ($val_data->fails()) {
        //     return ResponseTrait::sendResponse($val_data->errors()->all(),0,'Failed',422);
        // }
        $users = $this->user->store($val_data);

        if(!$users) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($users,1,'Success',200);
    }

    public function updateUser(Request $data, $id){

        $users =  $this->user->updateUser($data, $id);

        if(!$users) return ResponseTrait::sendResponse($data,0,'Failed',422);

        return ResponseTrait::sendResponse($users,1,'Success',200);
    }

    public function deleteUser($id){
        $users =  $this->user->deleteUser($id);
        if(!$users) return ResponseTrait::sendResponse($users,0,'Failed',422);

        return ResponseTrait::sendResponse($users,1,'Success',200);
    }
}

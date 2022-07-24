<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Traits\ResponseTrait;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->task = new Task();

    }

    public function getTasks(Request $req){

        $data_tasks =  $this->task->index($req);

        if(!$data_tasks) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }

    public function getTaskById($id){

        $data_tasks =  $this->task->show($id);

        if(!$data_tasks) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }

    public function storeTask(Request $data){

        $authUser = Auth::User();
        if($authUser['role'] == User::PRODUCT_OWNER){
            $data_task = $this->task->store($data);

            if(!$data_task) return ResponseTrait::sendResponse(null,0,'Failed',422);

            return ResponseTrait::sendResponse($data_task,1,'Success',200);
        }else{
            return ResponseTrait::sendResponse(null,2,'Restricted User',200);
        }
    }

    public function updateTask(Request $data, $id){

        $data_task =  $this->task->updateTask($data, $id);

        if(!$data_task) return ResponseTrait::sendResponse($data,0,'Failed',422);

        return ResponseTrait::sendResponse($data_task,1,'Success',200);
    }
    
    public function updateStatus(Request $data, $id){

        $data_task =  $this->task->updateStatus($data, $id);

        if($data_task == 0){
            return ResponseTrait::sendResponse(null,1,'No authorization to update the task status.',422);
        }

        if(!$data_task) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_task,1,'Success',200);
    }

    public function deletetask($id){
        $data_tasks =  $this->task->deletetask($id);
        if($data_task == 0) return ResponseTrait::sendResponse(null,1,'There are task under this task',200);
        if(!$data_tasks) return ResponseTrait::sendResponse($data_tasks,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }
}

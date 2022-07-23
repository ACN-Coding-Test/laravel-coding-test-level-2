<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Traits\ResponseTrait;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->task = new Task();

    }

    public function getTasks(){

        $data_tasks =  $this->task->index();

        if(!$data_tasks) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }

    public function getTaskById($id){

        $data_tasks =  $this->task->show($id);

        if(!$data_tasks) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }

    public function storeTask(Request $data){

        $data_task = $this->task->store($data);

        if(!$data_task) return ResponseTrait::sendResponse(null,0,'Failed',422);

        return ResponseTrait::sendResponse($data_task,1,'Success',200);
    }

    public function updateTask(Request $data, $id){

        $data_task =  $this->task->updateTask($data, $id);

        if(!$data_task) return ResponseTrait::sendResponse($data,0,'Failed',422);

        return ResponseTrait::sendResponse($data_task,1,'Success',200);
    }

    public function deletetask($id){
        $data_tasks =  $this->task->deletetask($id);
        if($data_task == 0) return ResponseTrait::sendResponse(null,1,'There are task under this task',200);
        if(!$data_tasks) return ResponseTrait::sendResponse($data_tasks,0,'Failed',422);

        return ResponseTrait::sendResponse($data_tasks,1,'Success',200);
    }
}

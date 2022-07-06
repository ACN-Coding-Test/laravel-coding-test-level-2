<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController as BaseController;

class TaskController extends BaseController
{
    public function addTask(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'user_create' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $uuid=Str::orderedUuid();

        $checkUser=User::where('username',$request->user_create)->first();
        $user_create=$checkUser->role;

        if($user_create == 'PRODUCT_OWNER'){
            $tasks = Task::create([
                'id' => $uuid,
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'NOT_STARTED',
                'project_id' => $request->project_id,
                'user_id' => $request->user_id,
            ]);

            $success['title'] =  $tasks->title;
            $success['description'] =  $tasks->description;
            $success['status'] =  $tasks->status;
   
            return $this->sendResponse($success, 'Task added successfully.');
        }
        else{
            return $this->sendError('Validation Error.', 'You not have permission to add Task');   
        }
    }

    public function getTask($id)
    {
        $count=Task::where('id',$id)->count();
        if($count>0){
            $Tasks=Task::where('id',$id)->get();
            return $this->sendResponse($Tasks, 'Successfully Parse Task Data.');
        }
        else{
            return $this->sendError('ID is not Valid.', 'Task Data Not Found');
        }
    }

    public function getAllTask()
    {
        $count=Task::count();
        if($count>0){
            $tasks=Task::get();
            return $this->sendResponse($tasks, 'Successfully Parse Task Data.');
        }
        else{
            return $this->sendError('Table is empty.', 'Task Data Not Found');
        }
    }

    public function deleteTask($id)
    {
        $taskDelete = Task::find($id);
    	$taskDelete->delete();

        $success['id'] =  $id;
   
        return $this->sendResponse($success, 'Successfully Delete an task.');
    }
}

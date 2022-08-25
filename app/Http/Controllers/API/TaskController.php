<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Validator;

class TaskController extends Controller
{
    public $tasks_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];
    
    public function index()
    {
        $Tasks = Task::all();
        return response(['Tasks' => TaskResource::collection($Tasks)]);
    }

    private function checkUserRole()
    {
        if(auth('api')->user()->role != 'PRODUCT_OWNER'){
            return false;
        }
        return true;
    }
    
    public function store(Request $request)
    {
        
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER.');
        }

        $data = $request->all();
        $data['status'] = 'NOT_STARTED';

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'status' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        if(!in_array($data['status'], $this->tasks_status)){
            return Response::deny("You must provide task status from following ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED']");
        }

        $Task = Task::create($data);

        return response(['Task' => new TaskResource($Task), 'message' => 'Task created successfully']);
    }

    public function show(Task $Task)
    {
        return response(['Task' => new TaskResource($Task)]);
    }

    public function update(Request $request, Task $Task)
    {
        $data = $request->all();

        if(!$this->checkUserRole()){
            if(auth('api')->user()->id != $data['user_id']){
                return Response::deny('You have no permission to edit task');
            }
            return Response::deny('You must be a PRODUCT_OWNER.');
        }

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'status' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        if(!in_array($request->status, $tasks_status)){
            return Response::deny("You must provide task status from following ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED']");
        }

        $Task->update($data);

        return response(['Task' => new TaskResource($Task), 'message' => 'Task updated successfully']);
    }

    public function destroy(Task $Task)
    {
        $Task->delete();

        return response(['message' => 'Task deleted successfully']);
    }
} 
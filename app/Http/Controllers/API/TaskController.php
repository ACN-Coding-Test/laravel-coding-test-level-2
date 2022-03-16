<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $tasks_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];
    public function __construct(Request $request) {
        if($request->role != 'PRODUCT_OWNER'){
            return Response::deny('You must be a PRODUCT_OWNER to continue creating tasks.');
        }
    }

    public function index()
    {
        $Tasks = Task::all();
        return response(['Tasks' => TaskResource::collection($Tasks)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->status = 'NOT_STARTED';
        $data = $request->all();

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

        $Task = Task::create($data);

        return response(['Task' => new TaskResource($Task), 'message' => 'Task created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $Task)
    {
        return response(['Task' => new TaskResource($Task)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $Task)
    {
        $task_db = Task::Find($request->id);
        
        $data = $request->all();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $Task)
    {
        $Task->delete();

        return response(['message' => 'Task deleted successfully']);
    }
}
<?php

namespace App\Http\Controllers\API;
use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
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
            return Response::deny('You must be a PRODUCT_OWNER to continue creating tasks.');
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

        // Check if user id is valid
        $user = User::find($request->user_id);
        if(!$user){
            return Response::deny("User not found to assign task!");
        }
        $project = Project::find($request->project_id);

        if(!$project){
            return Response::deny("Project not found!");
        }
        $Task = Task::create($data);
        
 
        $user->role = 'PRODUCT_OWNER';
        
        $user->save();

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
        
        $data = $request->all();
        return response(['data' => $request]);
        if(!$this->checkUserRole()){
            if(auth('api')->user()->id != $data['user_id']){
                return Response::deny('You have no permission to edit task');
            }
            return Response::deny('You must be a PRODUCT_OWNER to continue creating tasks.');
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
        if(!in_array($data['status'], $this->tasks_status)){
            return Response::deny("You must provide task status from following ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED']");
        }

        // Check if user id is valid
        $user = User::find($request->user_id);
        if(!$user){
            return Response::deny("User not found to assign task!");
        }
        $project = Project::find($request->project_id);

        if(!$project){
            return Response::deny("Project not found!");
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
<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public $tasks_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request, Task $task)
    {
        $this->authorize('PRODUCT_OWNER');

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'status' => 'string',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);

        $fields['status'] = $fields['status'] ?? 'NOT_STARTED';
        

        return Task::create($fields);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function assignTask(Request $request, Task $task, Project $project)
    {
        $this->authorize('PRODUCT_OWNER');

        $taskData = Task::find($request->id);
        $projectBelongsTo = Project::find($taskData->project_id)->user_id;

        if(auth('sanctum')->user()->id != $projectBelongsTo){
            return Response::deny('You have no permission to asign this task');
        }

        $request->validate([
            'user_id' => 'required',
        ]);

        $taskData->user_id = $request->user_id;
        $taskData->save();

        return $taskData;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Task $task)
    {
        $data = Task::find($request->id);

        if(auth('sanctum')->user()->id != $data->user_id){
            return Response::deny('You have no permission to update task status');
        }

        $fields = $request->validate([
            'status' => 'required',
        ]);

        if(isset($fields['status']) && !in_array($fields['status'], $this->tasks_status)){
            return Response::deny("You must provide task status from following ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED']");
        }

        $data = Task::find($request->id);
        $data->status = $request->status;
        $data->save();

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string',
        ]);

        $data = Task::find($request->id);

        if($request->title) {
            $data->title = $request->title;
        }
        if($request->description) {
            $data->description = $request->description;
        }

        $data->save();

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Task $task)
    {
        return Task::find($request->id);;
    }
}

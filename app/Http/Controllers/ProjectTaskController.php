<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class ProjectTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        //
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = 'NOT_STARTED';
        $task->project_id = $project->id;
        $task->user_id = $request->user_id;
        $task->save();

        return response()->json(['status' => 'success', 'message' => 'Task created successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Task $task)
    {
        //
        $validatedArray = $request->all();

        $validator = Validator::make($validatedArray, [
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $returnMessage['status'] = 'error';
            $returnMessage['message'] = $validator->errors()->first();
            return response()->json($returnMessage, 422);
        }

        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->save();

        return response()->json(['status' => 'success', 'message' => 'Task updated successfully.'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        //
        $task->delete();

        return response()->json(['status' => 'success', 'message' => 'Task deleted successfully.'], 201);
    }
}

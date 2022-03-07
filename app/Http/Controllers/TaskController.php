<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Str;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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
    public function store(Request $request,Project $project)
    {
        $request->validate([
            'name' => 'required|string|',
            'title' => 'required|string|',
            'description' => 'string',
            'status' => 'required|string|',
            'user_id' => 'required|exists:users,id',

        ]);
        $uuid = Str::uuid()->toString();
        $project = Str::uuid()->toString();
        $userid = Str::uuid()->toString();
        $status ='NOT_STARTED';

        $task= Task::create([
            'id' => $uuid,
            'title' =>$request->title,
            'description' =>$request->description,
            'status' =>$status,
            'project_id ' =>$request->$project,
            'user_id ' =>$request->user_id,
        ]);
        return response()->json(['task'=>$task],200);    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $Task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request->all());
        return $task;      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $Task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $Task, $id)
    {
        return Task::destroy($id);
    }
}

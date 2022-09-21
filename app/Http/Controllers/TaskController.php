<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
 
    public function index()
    {
        return Task::all();
    }



    public function store(Request $request)
    {
        $task =Task::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'project_id'=>$request->project_id,
            'user_id'=>$request->user_id,
        ]);
        return $task;
    }


    public function show(Task $task)
    {
        return $task;
    }



    public function update(Request $request, Task $task)
    {
        
        $task->title=$request->title;
        $task->description=$request->description;
        $task->project_id=$request->project_id;
        $task->user_id=$request->user_id;
        $task->save();

        return $task;
    }


    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json('Task Deleted');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return ModelResource::collection($tasks);
    }

    public function show(Task $task)
    {
        return new ModelResource($task);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return new ModelResource($task);
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return new ModelResource($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}

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
    public function index()
    {
        $Tasks = Task::all();
        return response(['Tasks' => TaskResource::collection($Tasks)]);
    }

    public function store(Request $request)
    {
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

        $validator = Validator::make($data, [
            'title' => 'required|max:255',
            'status' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
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
<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateRequest;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return $this->success($tasks, 'Task list', 200);
    }

    public function store(CreateRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id
        ]);

        return $this->success($task, 'Task has been created', 201);
    }

    public function show(Task $task)
    {
        return $this->success($task, 'Task detail', 200);
    }

    public function update(CreateRequest $request, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->save();

        return $this->success($task, 'Task Successfully Updated', 200);
    }

    public function destroy(Task $task)
    {
        if ($task->delete()) {
            return $this->success($task, 'Task Successfully Deleted', 200);
        }

        return $this->error('Something went wrong');
    }
}

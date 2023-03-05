<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CreateRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = new Task;
        if(auth()->user()->hasRole('Team Member')) {
            $tasks = $tasks->where('user_id', auth()->user()->id);
        }
        return $this->success($tasks->get(), 'Task list', 200);
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

    public function assignTask(Task $task, User $user)
    {
        if (!$this->authorize('update', $task)) {
            return $this->error('You can not assign user to this project', 403);
        }

        if(!$user->hasRole('Team Member')) {
            return $this->error('User not a team member', 403);
        }

        if ($task->status !== 'NOT_STARTED') {
            return $this->error('Task status has been updated, You can not assign new user', 403);
        }

        $task->user_id = $user->id;
        $task->save();

        return $this->success('User assigned successfully', 200);
    }

    public function updateStatus(Task $task, Request $request)
    {
        if(!$this->authorize('update', $task)){
            return $this->error('You can not update this task', 403);
        }

        if ($task->status !== 'NOT_STARTED') {
            return $this->error('Task status has been updated, You can not assign new user', 403);
        }

        $task->status = $request->status;
        $task->save();

        return $this->success('Task status updated', 200);
    }
}

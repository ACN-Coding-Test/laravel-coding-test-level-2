<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('acl:create:task')->only(['store']);
        $this->middleware('acl:delete:task')->only(['destroy']);
    }

    /**
      Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $canListAllTasks = $request->user()->tokenCan('list:tasks');
        $canListOwnTasks = $request->user()->tokenCan('list:own:tasks');
        if (!$canListAllTasks && !$canListOwnTasks) {
            throw new UnauthorizedException('You are not authorized for this action', 403);
        }
        if ($canListAllTasks) {
            return Task::simplePaginate(10);
        }
        $userId = $request->user()->id;
        return Task::where(['user_id' => $userId])->simplePaginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $input = $request->input();

        $task = Task::create([
            'title' => $input['title'],
            'description' => $input['description'],
            'status' => $input['status'],
            'project_id' => $input['project_id'],
            'user_id' => $input['user_id'],
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $canViewTask = $request->user()->tokenCan('view:task');
        $canViewOwnTask = $request->user()->tokenCan('view:own:task');
        if (!$canViewTask && !$canViewOwnTask) {
            throw new UnauthorizedException('You are not authorized for this action', 403);
        }
        if (
            !$canViewTask
            && $canViewOwnTask
            && $task->user_id !== $request->user->id
        ) {
            throw new UnauthorizedException('You are not authorized for this action', 403);
        }

        return $task->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $taskId)
    {

        $canUpdateTask = $request->user()->tokenCan('update:task');
        $canUpdateOwnTask = $request->user()->tokenCan('update:own:task');
        if (!$canUpdateTask && !$canUpdateOwnTask) {
            throw new UnauthorizedException('You are not authorized for this action', 403);
        }
        $task = Task::findOrFail($taskId);

        if (
            !$canUpdateTask
            && $canUpdateOwnTask
            && $task->user_id !== $request->user->id
        ) {
            throw new UnauthorizedException('You are not authorized for this action', 403);
        }
        $updatable = [
            'title',
            'description',
            'status',
            'project_id',
        ];
        // A user cannot assign the task to another member
        // Only product owner can
        if ($canUpdateTask) {
            array_push($updatable, 'user_id');
        }
        $taskData = $request->only($updatable);
        $task->update($taskData);
        return $task->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Task::paginate(15);
        return response()->json($tasks);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $task = Task::find($id);

        return response()->json($task);
    }

    /**
     * @param TaskRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(TaskRequest $request): JsonResponse
    {
        $this->authorize('crud-tasks');
        try {

            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status_id = $request->status_id;
            $task->project_id = $request->project_id;
            $task->user_id = $request->user_id;
            $task->save();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully created task",
            "data" => $task
        ]);
    }

    /**
     * @param $id
     * @param TaskRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update($id, TaskRequest $request): JsonResponse
    {
        $this->authorize('crud-tasks');
        try {

            $task = Task::find($id);
            if ($request->method() == 'PATCH') {

                $task->update($request->only(['status_id', 'user_id']));

            } else {

                $task->title = $request->title;
                $task->description = $request->description;
                $task->status_id = $request->status_id;
                $task->project_id = $request->project_id;
                $task->user_id = $request->user_id;
                $task->save();

            }


        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully updated task",
            "data" => $task
        ]);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {

            Task::find($id)->delete();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "Error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully destroyed task"
        ]);
    }
}

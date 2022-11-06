<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Exception;
use Auth;
use DB;

class TaskController extends Controller
{
    public function index()
    {
        try {
            
            $tasks = Task::all();

            return response()->json([
                'status' => 200,
                'message' => 'Task List Successfully Retrieved',
                'data' => $tasks->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function store(StoreTaskRequest $request)
    {
        DB::beginTransaction();

        try {
            
            $task = Task::create([
                'title'          => $request->title,
                'description'    => $request->description,
                'status'         => 'NOT_STARTED',
                'project_id'     => $request->project_id,
                'user_id'        => $request->user_id,
            ]);

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Task Successfully Created',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(Task $task)
    {
        try { 
            
            return response()->json([
                'status' => 200,
                'message' => 'Task Successfully Retrieved',
                'data' => $task->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function update(UpdateTaskRequest $request, Task $task)
    { 
        DB::beginTransaction();

        try {

            $task->title          = $request->title;
            $task->description    = $request->description;
            $task->status         = $request->status;
            $task->project_id     = $request->project_id;
            $task->user_id        = $request->user_id;
            $task->save();
            
            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Task Successfully Updated',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy(Task $task)
    {
        DB::beginTransaction();

        try {

            $task->delete();

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Task Successfully Deleted',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function taskListByProject($id)
    {
        try {
            
            $tasks = Task::where('project_id', $id)->get();

            return response()->json([
                'status' => 200,
                'message' => 'Task List Successfully Retrieved',
                'data' => $tasks->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}

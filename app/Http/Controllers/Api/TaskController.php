<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateTaskStatusRequest;
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
            
            if(getRole() == 'ADMIN')
            {
                $tasks = Task::all();
            }elseif(getRole() == 'PRODUCT_OWNER')
            {
                $tasks = Task::all();
            }
            else
            {
                $tasks = Task::where('user_id', Auth::user()->id)->get();
            }
            
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

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            $check_user_availability = Task::where('project_id', $request->project_id)->where('user_id', $request->user_id)->first();

            if(!empty($check_user_availability) || $check_user_availability != null){
                return response()->json([
                    'status' => 401,
                    'message' => 'User is allowed to registered only one task for each project.',
                ], 401);
            }
            
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

        $task_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];

        try {

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            if(in_array($request->status, $task_status) == false){
                return response()->json([
                    'status' => 401,
                    'message' => 'Only NOT_STARTED, IN_PROGRESS, READY_FOR_TEST and COMPLETED task\'s status are allowed',
                ], 401);
            }

            $check_user_availability = Task::where('project_id', $request->project_id)
                                        ->where('user_id', $request->user_id)
                                        ->where('id', '!=',$task->id)
                                        ->get()
                                        ->toArray();
                                        
            if(!empty($check_user_availability) || $check_user_availability != null){
                return response()->json([
                    'status' => 401,
                    'message' => 'User is allowed to registered only one task for each project.',
                ], 401);
            }

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

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

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

    public function updateTaskStatus(UpdateTaskStatusRequest $request, Task $task)
    { 
        DB::beginTransaction();

        $task_status = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];

        try {

            if(in_array($request->status, $task_status) == false){
                return response()->json([
                    'status' => 401,
                    'message' => 'Only NOT_STARTED, IN_PROGRESS, READY_FOR_TEST and COMPLETED task\'s status are allowed',
                ], 401);
            }

            $task->description    = $request->description;
            $task->status         = $request->status;
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
}

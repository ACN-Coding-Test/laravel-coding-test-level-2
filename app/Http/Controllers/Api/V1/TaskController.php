<?php
namespace App\Http\Controllers\Api\V1;
use App\Models\Task;
use App\Http\Controllers\Api\V1\BaseController as BaseController;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends BaseController
{
    public function index(Request $request)
    {
        $tasks = Task::all();
        return new TaskResource($tasks);
    }

    public function show($id)
    {
        $task = Task::find($id);
        return new TaskResource($task);
    }

    public function store(Request $request)
    {       
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'status' => 'required',
            'project_id' => 'required',
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Task = Task::create($data);
        return new TaskResource($Task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task->update($data);
        return new TaskResource($task);
    }

    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }
}

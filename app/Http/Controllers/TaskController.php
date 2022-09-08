<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Requests\Task\StoreRequest as TaskStoreRequest;
use App\Http\Requests\Task\UpdateRequest as TaskUpdateRequest;
use App\Http\Middleware\ProductOwnerAccess;
use App\Http\Middleware\AssignTaskAccess;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\PaginateTrait;

class TaskController extends Controller
{
    use PaginateTrait;

    public function __construct()
    {
        $this->middleware([ProductOwnerAccess::class])->only(['store']);
        $this->middleware([AssignTaskAccess::class])->only(['update','store']);

    }
    public function index(Request $request)
    {
        $query = Task::DtFilter($request);

        $setDatatable = $this->setDatatable($request,$query,'tittle');

        return TaskResource::collection($setDatatable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        $validated = $request->validated();

        $validated['status'] = Task::NOT_STARTED;
        
        $query = Task::create($validated);
    
        return new TaskResource($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TaskResource($task);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request,Task $task)
    {
        $validated = $request->validated();

        if(Auth::user()->id != $task->user_id){
            return ResponseTrait::sendResponse(null,0,'You dont have access to update task',400);
        }

        $query = $task->update($validated);

        return new TaskResource($task);
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

      return response()->json(true, 204);
    }
}

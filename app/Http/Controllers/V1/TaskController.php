<?php

namespace App\Http\Controllers\V1;

use Exception;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Auth\Access\AuthorizationException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $allTasks = [];

            $this->authorize('getAllTasks', Task::class);

            $tasks = Task::select('*');

            $tasks = $tasks->get();

            foreach ($tasks as $key => $task) {
                if($task->users && $task->projects) {
                    $allTasks[] = [
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'status' => $task->status,
                        'created_at' => $task->created_at,
                        'updated_at' => $task->updated_at,
                        'user' => $task->users->username,
                        'project' => $task->projects->name,
                    ];
                }
            }

            return response(
                $allTasks
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $this->authorize('showTask', Task::class);

            $task = Task::find($id);

            if(!($task->users && $task->projects)) {
                return response(
                    [
                        'errors' => 'The requested project or user is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            return response(
                [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status,
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at,
                    'user' => $task->users->username,
                    'project' => $task->projects->name,
                ]
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Store a newly created project resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $this->authorize('storeTask', Task::class);

            $projectId = $request->input('project_id');
            $userId = $request->input('user_id');

            // check project availability
            $project = Project::find($projectId);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // check user availability
            $user = User::find($userId);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $project = Task::create(
                [
                    'title' => $request->input('title'),
                    'description' => @$request->input('description'),
                    'status' => Task::STATUS_TYPE_NOT_STARTED,
                    'project_id' => $projectId,
                    'user_id' => $userId,
                ]
            );

            return response($project);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(EditTaskRequest $request, $id)
    {
        try {
            $this->authorize('editTask', Task::class);

            $projectId = $request->input('project_id');
            $userId = $request->input('user_id');
            $status = $request->input('status');

            // check project availability
            $project = Project::find($projectId);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // check user availability
            $user = User::find($userId);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $task = Task::find($id);

            if(!$task) {
                return response(
                    [
                        'errors' => 'The requested task is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // team member can not change the not started status
            if((Role::ROLE_TYPE_DEVELOPER == auth()->user()->role_id) && (Task::STATUS_TYPE_NOT_STARTED == $status)) {
                return response(
                    [
                        'errors' => 'The dev tema member can not change the not started status'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->status = $status;

            // only product owner can change the user and the project
            if((Role::ROLE_TYPE_PRODUCT_OWNER == auth()->user()->role_id)) {
                $task->project_id = $projectId;
                $task->user_id = $userId;
            }

            $task->update();

            return response($task);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        try {
            $this->authorize('updateTask', Task::class);

            $projectId = $request->input('project_id');
            $userId = $request->input('user_id');
            $status = $request->input('status');

            // check project availability
            $project = Project::find($projectId);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // check user availability
            $user = User::find($userId);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $task = Task::find($id);

            if(!$task) {
                return response(
                    [
                        'errors' => 'The requested task is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            // team member can not change the not started status
            if((Role::ROLE_TYPE_DEVELOPER == auth()->user()->role_id) && (Task::STATUS_TYPE_NOT_STARTED == $status)) {
                return response(
                    [
                        'errors' => 'The dev tema member can not change the not started status'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->status = $status;

            // only product owner can change the user and the project
            if((Role::ROLE_TYPE_PRODUCT_OWNER == auth()->user()->role_id)) {
                $task->project_id = $projectId;
                $task->user_id = $userId;
            }

            $task->update();

            return response($task);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('destroyTask', Task::class);

            $task = Task::find($id);

            if(!$task) {
                return response(
                    [
                        'errors' => 'The requested task is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $task->delete();

            return response(
                [
                    'message' => 'This task deleted successfully'
                ],
                Response::HTTP_OK
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
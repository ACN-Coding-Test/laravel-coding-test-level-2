<?php

namespace App\Http\Controllers\V1;

use Exception;
use App\Models\User;
use App\Models\Project;
use App\Helpers\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProjectRequest;
use App\Http\Requests\IndexProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $this->authorize('getAllProjects', Project::class);

            $projects = Project::all();

            return response(
                $projects
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
            $this->authorize('showProject', Project::class);

            $project = Project::find($id);

            return response(
                $project
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
    public function store(StoreProjectRequest $request)
    {
        try {
            $this->authorize('storeProject', Project::class);

            $project = Project::create(
                [
                    'name' => $request->input('name'),
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
    public function edit(EditProjectRequest $request, $id)
    {
        try {
            $this->authorize('editProject', Project::class);

            $project = Project::find($id);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $project->name = $request->input('name');

            $project->update();

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        try {
            $this->authorize('updateProject', Project::class);

            $project = Project::find($id);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $project->name = $request->input('name');

            $project->update();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->authorize('destroyProject', Project::class);

            $project = Project::find($id);

            if(!$project) {
                return response(
                    [
                        'errors' => 'The requested project is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $project->delete();

            return response(
                [
                    'message' => 'This project deleted successfully'
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

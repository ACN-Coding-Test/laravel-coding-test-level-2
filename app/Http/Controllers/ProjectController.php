<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\CreateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $this->authorize('view', Project::class);

        return ProjectResource::collection(Project::all());
    }

    public function store(CreateProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        return ProjectResource::make(Project::create($request->validated()));
    }

    public function show(Project $project)
    {
        $this->authorize('view', Project::class);

        return ProjectResource::make($project);
    }

    public function updateWithPut(CreateProjectRequest $createProjectRequest, Project $project)
    {
        $this->authorize('update', Project::class);

        $project->name = $createProjectRequest->input('name', $project->name);
        $project->timestamps = false;
        $project->save();

        return ProjectResource::make($project);
    }

    public function updateWithPatch(CreateProjectRequest $createProjectRequest, Project $project)
    {
        $this->authorize('update', Project::class);

        $project->update($createProjectRequest->validated());

        return ProjectResource::make($project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', Project::class);

        $project->delete();

        return response()->json([
            'message' => $project->name . ' has been deleted!',
            'success' => true
        ]);
    }
}

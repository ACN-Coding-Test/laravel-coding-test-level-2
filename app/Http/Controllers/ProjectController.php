<?php

namespace App\Http\Controllers;

use App\Http\Resources\ModelResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return ModelResource::collection($projects);
    }

    public function show(Project $project)
    {
        return new ModelResource($project);
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return new ModelResource($project);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return new ModelResource($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $Projects = Project::all();
        return response(['Projects' => ProjectResource::collection($Projects)]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Project = Project::create($data);

        return response(['Project' => new ProjectResource($Project), 'message' => 'Project created successfully']);
    }

    public function show(Project $Project)
    {
        return response(['Project' => new ProjectResource($Project)]);
    }

    public function update(Request $request, Project $Project)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $Project->update($data);

        return response(['Project' => new ProjectResource($Project), 'message' => 'Project updated successfully']);
    }

    public function destroy(Project $Project)
    {
        $Project->delete();

        return response(['message' => 'Project deleted successfully']);
    }
} 
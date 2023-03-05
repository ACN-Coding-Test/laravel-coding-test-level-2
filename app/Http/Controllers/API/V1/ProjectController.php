<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return $this->success($projects, 'Project list', 200);
    }

    public function store(CreateRequest $request)
    {
        $project = Project::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return $this->success($project, 'Project has been created', 201);
    }

    public function show(Project $project)
    {
        return $this->success($project, 'Project detail', 200);
    }

    public function update(CreateRequest $request, Project $project)
    {
        if (!$this->authorize('update', $project)) {
            return $this->error('You can not update this project', 403);
        }

        $project->name = $request->name;
        $project->save();

        return $this->success($project, 'Project Successfully Updated', 200);
    }

    public function destroy(Project $project)
    {
        if (!$this->authorize('delete', $project)) {
            return $this->error('You can not update this project', 403);
        }

        if ($project->delete()) {
            return $this->success($project, 'Project Successfully Deleted', 200);
        }

        return $this->error('Something went wrong');
    }
}

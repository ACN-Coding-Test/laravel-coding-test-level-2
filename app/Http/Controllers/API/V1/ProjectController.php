<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = new Project;

        // Search project name
        if($request->has('q')){
            $projects->where('name', 'LIKE', '%' . $request->q . '%');
        }

        // search by sort by and direction
        $projects->orderBy($request->sortBy ?? 'id', $request->sortDirection ?? 'ASC');

        return $this->success($projects->paginate($request->pageSize ?? 10), 'Project list', 200);
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

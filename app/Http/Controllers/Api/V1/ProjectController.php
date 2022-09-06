<?php
namespace App\Http\Controllers\Api\V1;
use App\Models\Project;
use App\Http\Controllers\Api\V1\BaseController as BaseController;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redis;

class ProjectController extends BaseController
{
    public function index(Request $request)
    {
        $Project = Project::all();
        return new ProjectResource($Project);
    }

    public function show($id)
    {
        $project = Project::find($id);
        return new ProjectResource($project);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|unique:projects,name',
        ]);
        $data['name'] = $data['name'];
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $Project = Project::create($data);
        return new ProjectResource($Project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|unique:projects,name,'.$id,
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $project->update($data);
        return new ProjectResource($project);
    }

    public function destroy(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json([
            'message' => 'Project deleted successfully'
        ], 200);
    }
}

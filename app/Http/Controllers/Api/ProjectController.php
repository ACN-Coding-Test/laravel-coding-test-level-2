<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProjectController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $projects = Project::with('tasks.user')->paginate(3);
        return response()->json($projects);

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $project = Project::with('tasks.user')->find($id);

        return response()->json($project);
    }

    /**
     * @param ProjectRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $this->authorize('crud-projects');
        try {

            $project = new Project();
            $project->name = $request->name;
            $project->product_owner = Auth::id();
            $project->save();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully created project",
            "data"=>$project
        ]);
    }

    /**
     * @param $id
     * @param ProjectRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update($id, ProjectRequest $request): JsonResponse
    {
        $this->authorize('crud-projects');
        try{

            $project = Project::find($id);
            if($request->method() == 'PATCH'){

                $project->update($request->only('product_owner'));

            }else{

                $project->name = isset($request->name) && $request->name != '' ? $request->name : $project->name;
                $project->product_owner = isset($request->product_owner) && $request->product_owner != '' ? $request->product_owner : $project->product_owner;
                $project->save();

            }


        }catch (Throwable $throwable) {

            return response()->json([
                "status" => "error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully updated project",
            "data" => $project
        ]);

    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy($id): JsonResponse
    {
        $this->authorize('crud-projects');
        try {

            Project::find($id)->delete();

        } catch (Throwable $throwable) {

            return response()->json([
                "status" => "Error",
                "message" => $throwable->getMessage()
            ], 500);

        }

        return response()->json([
            "status" => "success",
            "message" => "Successfully destroyed project"
        ]);
    }
}

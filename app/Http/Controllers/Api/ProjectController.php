<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Exception;
use Auth;
use DB;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            
            $projects = Project::all();

            return response()->json([
                'status' => 200,
                'message' => 'Project List Successfully Retrieved',
                'data' => $projects->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function store(StoreProjectRequest $request)
    {
        DB::beginTransaction();

        try {
            
            $project = Project::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Project Successfully Created',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(Project $project)
    {
        try { 
            
            return response()->json([
                'status' => 200,
                'message' => 'Project Successfully Retrieved',
                'data' => $project->toArray()
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function update(UpdateProjectRequest $request, Project $project)
    { 
        DB::beginTransaction();

        try {

            $project->name = $request->name;
            $project->save();
            
            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Project Successfully Updated',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function destroy(Project $project)
    {
        DB::beginTransaction();

        try {

            $project->delete();

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Project Successfully Deleted',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Auth;
use DB;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        try {

            $search = $request->q ?? null;
            $pageIndex = $request->pageIndex ?? 0;
            $pageSize = $request->pageSize ?? 3;
            $sortBy = $request->sortBy ?? 'name';
            $sortDirection = $request->sortDirection ?? 'ASC';
            
            $projects = Project::where( 'name', 'LIKE', '%' . $search . '%' )
                            ->skip($pageIndex*$pageSize)
                            ->take($pageSize)
                            ->orderBy($sortBy, $sortDirection)
                            ->get();

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

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }
            
            $project = Project::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return response()->json([
                'status'    => 200,
                'message'   => 'Project Successfully Created',
                'data'      => $project->toArray()
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

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

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

            if(getRole() != 'PRODUCT_OWNER'){
                return response()->json([
                    'status' => 401,
                    'message' => 'you do not have permission to access this API',
                ], 401);
            }

            $tasks = Task::where('project_id', $project->id)->get();

            if(!empty($tasks->toArray())){
                foreach($tasks as $task){
                    $task->delete();
                }  
            }

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

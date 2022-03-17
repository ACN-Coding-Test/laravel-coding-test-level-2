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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        $pageSize = isset($_GET['pageSize'])?$_GET['pageSize']:2;
        $sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:'name';
        $sortDirection = isset($_GET['sortDirection'])?$_GET['sortDirection']:'ASC';
        $Projects = Project::orderBy($sortBy, $sortDirection);
        $q = isset($_GET['q'])?$_GET['q']:'';
        $Projects = $q?$Projects->where('name', 'LIKE', "%$q%"):$Projects;
        $Projects = $Projects->paginate($pageSize);
        return response(['Projects' => $Projects]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function checkUserRole()
    {
        if(auth('api')->user()->role != 'PRODUCT_OWNER'){
            return false;
        }
        return true;
    }

    public function store(Request $request)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER to continue.');
        }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $Project)
    {
        
        return response(['Project' => new ProjectResource($Project)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $Project)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER to continue.');
        }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $Project)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER to continue.');
        }
        $Project->delete();

        return response(['message' => 'Project deleted successfully']);
    }
}
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
        $pageSize = isset($_GET['pageSize'])?$_GET['pageSize']:2;
        $sortBy = isset($_GET['sortBy'])?$_GET['sortBy']:'name';
        $sortDirection = isset($_GET['sortDirection'])?$_GET['sortDirection']:'ASC';
        $Projects = Project::orderBy($sortBy, $sortDirection);
        $q = isset($_GET['q'])?$_GET['q']:'';
        $Projects = $q?$Projects->where('name', 'LIKE', "%$q%"):$Projects;
        $Projects = $Projects->paginate($pageSize);
        return response(['Projects' => $Projects]);
    }

    private function checkUserRole()
    {
        if(auth('api')->user()->role != 'PRODUCT_OWNER'){
            return false;
        }
        return true;
    }

    public function store(Request $request)
    {
        if($request->role != 'PRODUCT_OWNER'){
            return Response::deny('You must be a PRODUCT_OWNER.');
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

    public function show(Project $Project)
    {
        return response(['Project' => new ProjectResource($Project)]);
    }

    public function update(Request $request, Project $Project)
    {
        
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER.');
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

    public function destroy(Project $Project)
    {
        if(!$this->checkUserRole()){
            return Response::deny('You must be a PRODUCT_OWNER.');
        }
        
        $Project->delete();

        return response(['message' => 'Project deleted successfully']);
    }
} 
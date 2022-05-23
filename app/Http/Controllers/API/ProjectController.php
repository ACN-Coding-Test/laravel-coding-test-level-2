<?php

namespace App\Http\Controllers\API;

use Illuminate\Auth\Access\Response;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = isset($_GET['q']) 
            ? $_GET['q'] 
            : '';

        $pageSize = isset($_GET['pageSize'])
            ? $_GET['pageSize']
            : 2;

        $sortBy = isset($_GET['sortBy']) 
            ? $_GET['sortBy']
            :'name';
        
        $sortDirection = isset($_GET['sortDirection'])
            ? $_GET['sortDirection']
            : 'ASC';

        $Projects = Project::orderBy($sortBy, $sortDirection);

        $Projects = $query 
            ? $Projects->where('name', 'LIKE', "%$query%") 
            : $Projects;
            
        $Projects = $Projects->paginate($pageSize);

        return $Projects;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('PRODUCT_OWNER');

        $fields = $request->validate([
            'name' => 'required|string|unique:projects,name',
            'user_id' => 'string',
        ]);

        $fields['user_id'] = $fields['user_id'] ??auth('sanctum')->user()->id;

        return Project::create($fields);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return $project;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $this->authorize('PRODUCT_OWNER');
        $request->validate([
            'name' => 'required|unique:projects',
        ]);

        $project->update($request->all());

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('PRODUCT_OWNER');
        
        $project->delete();

        return response([
            'message' => 'Project deleted successfully'
        ], 201);
    }
}

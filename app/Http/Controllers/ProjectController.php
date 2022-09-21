<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        return Project::all();
    }


    public function store(Request $request)
    {
        $project =Project::create(['name'=>$request->name]);
        return $project;
    }


    public function show(Project $project)
    {
        return $project;
    }

 
    public function update(Request $request, Project $project)
    {
      $project->name =$request->name;
      $project->save();
      return $project;
    }

 
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json('Project deleted');
    }
}

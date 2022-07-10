<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all();
    }

    public function show($project)
    {
        return Project::find($project);
    }
    public function create(Request $req)
    {
        $project = new Project;
        $project->name=$req->name;
        $project->created_by=$req->user_id;
        $result=$project->save();
        if($result) {
          return 'file created';
        }
        else {
          return 'failed';
        }
    }
    public function update(Request $req, $project)
      {
        $project = Project::find($project);
        $project->name=$req->name;
        $project->created_by=$req->created_by;
        $result=$project->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function patch(Request $req, $project)
    {
        $project = Project::find($project);
        if($req->name)
        {
          $project->name=$req->name;
        }
        if($req->created_by)
        {
          $project->created_by=$req->created_by;
        }
        $result=$project->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function destroy($project)
    {
        $project = Project::find($project);
        $result = $project->delete();
        if($result){
          return "records has been deleted";
        }
        else {
          return "error";
        }
    }
}

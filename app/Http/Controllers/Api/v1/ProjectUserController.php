<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    public function index()
    {
        return ProjectUser::all();
    }

    public function show($projectuser)
    {
        return ProjectUser::find($projectuser);
    }
    public function create(Request $req)
    {
        $projectuser = new ProjectUser;
        $projectuser->user_id=$req->user_id;
        $projectuser->project_id=$req->project_id;
        $result=$projectuser->save();
        if($result) {
          return 'file created';
        }
        else {
          return 'failed';
        }
    }
    public function update(Request $req, $projectuser)
      {
        $projectuser = ProjectUser::find($projectuser);
        $projectuser->user_id=$req->user_id;
        $projectuser->project_id=$req->project_id;
        $result=$projectuser->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function patch(Request $request, $projectuser)
    {
        $projectuser = ProjectUser::find($projectuser);
        if($req->user_id)
        {
          $projectuser->user_id=$req->user_id;
        }
        if($req->project_id)
        {
          $projectuser->project_id=$req->project_id;
        }
        $result=$projectuser->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function destroy(ProjectUser $projectuser)
    {
        $projectuser = ProjectUser::find($projectuser);
        $result = $projectuser->delete();
        if($result){
          return "records has been deleted";
        }
        else {
          return "error";
        }
    }
}

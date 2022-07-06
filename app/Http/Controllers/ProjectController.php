<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends BaseController
{
    public function addProject(Request $request)
    {
        //dd('hai');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'user_create' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $uuid=Str::orderedUuid();

        $checkUser=User::where('username',$request->user_create)->first();
        $user_create=$checkUser->role;

        if($user_create == 'PRODUCT_OWNER'){
            $project = Project::create([
                'id' => $uuid,
                'name' => $request->name,
            ]);

            $success['name'] =  $project->name;
   
            return $this->sendResponse($success, 'Project added successfully.');
        }
        else{
            return $this->sendError('Validation Error.', 'You not have permission to add project');   
        }
    }

    public function getProject($id)
    {
        $count=Project::where('id',$id)->count();
        if($count>0){
            $projects=Project::where('id',$id)->get();
            return $this->sendResponse($projects, 'Successfully Parse Project Data.');
        }
        else{
            return $this->sendError('ID is not Valid.', 'Project Data Not Found');
        }
    }

    public function getAllProject()
    {
        $count=Project::count();
        if($count>0){
            $projects=Project::get();
            return $this->sendResponse($projects, 'Successfully Parse Project Data.');
        }
        else{
            return $this->sendError('Table is empty.', 'User Data Not Found');
        }
    }

    public function deleteProject($id)
    {
        $projectDelete = Project::find($id);
    	$projectDelete->delete();

        $success['id'] =  $id;
   
        return $this->sendResponse($success, 'Successfully Delete an project.');
    }
}

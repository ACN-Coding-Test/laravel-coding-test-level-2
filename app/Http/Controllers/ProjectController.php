<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
     function getprojects($id=null){
        if($id){
            $result = Project::find($id);
        }else{
            $result = Project::all();
        }
        
        if((!empty($result)) && (count($result)>0)){
             return $result;
        }else{
            return response()->json(['message'=>'No Data Found']);
        }
    }

    function createproject(Request $req){
        $project = new Project;
        $project->name=$req->input('name');
        $project->save();
        return $project;
    }

    function updateproject(Request $req){
        $project = Project::find($req->id);
        $project->name=$req->input('name');
        $result=$project->save();

        if($result){
            return response()->json(['message'=>'Successfully Updated']);
        }else{
            return response()->json(['message'=>'Update Failed']);
        }
    }

    function deleteproject(Request $req){
        $project = Project::find($req->id);
        $result = $project->delete();
        if($result){
            return response()->json(['message'=>'Successfully Deleted']);
        }else{
            return response()->json(['message'=>'Delete Failed']);
        }
    }
}
